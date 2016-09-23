<?php

namespace App\Http\Controllers\Admin;

use App\Services\admin\PermissionService;
use App\Models\Permission;
use Illuminate\Http\Request;

use App\Http\Requests;

class PermissionController extends BasicController
{

	protected $permissionService;

	public function __construct(PermissionService $permissionService)
	{
		parent::__construct();

		$this->permissionService = $permissionService;

	}

	protected function method_permission()
	{
		$this->middleware('level:'.config('admin.superadmin_level'));
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request)
	{

		//获取权限列表

		$input = [
			'keyword' => $request->input('keyword',''),
		];

		//条件
		$where = '';

		if($input['keyword']){
			$where.= " and (slug like '%{$input['keyword']}%' or name like '%{$input['keyword']}%' ) ";
		}

		$permissions = Permission::whereRaw(" 1 ".$where)->orderBy('created_at','desc')->paginate(config('admin.show_pages'));

		$permissions->transform(function($v){
			if($v->parent_id){
				$v->parent_name = Permission::find($v->parent_id)->name;
			}
			return $v;
		});

		return view($this->view,compact('permissions','input'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
		//获取所有顶级权限
		$p_permissions = Permission::where('parent_id',0)->get();

		return view($this->view,compact('p_permissions'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$input=$request->all();

		$exist = Permission::where('name',$input['name'])->orWhere('slug',$input['slug'])->first();

		if($exist){
			return $this->error_back('已存在相同纪录，请修改后重新提交！');
		}

		$response=Permission::create($input);

		if(!$response){

			return $this->error_back(trans('admin.store_error_msg'));
		}

		return redirect('manage/permission');



	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id,Request $request)
	{

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$permission=Permission::find($id);

		//获取所有顶级权限
		$p_permissions = Permission::where('parent_id',0)->get();

		return view($this->view,compact('permission','p_permissions'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$param=$request->input('param');


		if($param=='cyesno'){
			return $this->permissionService->changeYesOrNo($id,$request,$this);
		}

		$permission = Permission::find($id);

		if(!$permission){
			return $this->error_back(trans('admin.not_exist_msg'));
		}

		$input=$request->all();


		$exist = Permission::where('id','<>',$id)
			->where(function($query) use($input){
				$query->where('name',$input['name'])
					->orWhere('slug',$input['slug']);
			})->first();

		if($exist){
			return $this->error_back(trans('admin.exist_msg'));
		}

		$response=$permission->update($input);

		if(!$response){

			return $this->error_back(trans('admin.update_error_msg'));
		}

		return redirect('manage/permission');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$permission_id = $id ;

		$permission = Permission::find($permission_id);

		if(!$permission){
			return response([
				'status'=>0,
				'info'  =>trans('admin.not_exist_msg')
			]);
		}


		\DB::beginTransaction();

		//删除角色权限
		$permissionRole = $permission->roles()->get();

		foreach($permissionRole as $pr){
			$pr->detachPermission($permission);
		}


		//删除权限
		$deletePermission = $permission->delete();

		if($deletePermission===false){
			\DB::rollback();
			return response([
				'status'=>0,
				'info'  =>$this->destroy_error_msg
			]);
		}

		\DB::commit();

		return response([
			'status'=>1,
			'info'  =>'删除成功！'
		]);
	}
}
