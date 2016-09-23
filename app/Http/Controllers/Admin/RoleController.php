<?php

namespace App\Http\Controllers\Admin;

use Bican\Roles\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class RoleController extends BasicController
{
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

		//获取项目列表

		$input = [
			'keyword' => $request->input('keyword',''),
		];

		//条件
		$where = '';

		if($input['keyword']){
			$where.= " and (slug like '%{$input['keyword']}%' or name like '%{$input['keyword']}%' ) ";
		}


		$roles = Role::whereRaw(" 1 ".$where)->orderBy('created_at','desc')->paginate(config('admin.show_pages'));

		$roles->transform(function($v){

			return $v;
		});


		return view($this->view,compact('roles','input'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
		return view($this->view);
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

		$exist = Role::where('name',$input['name'])->orWhere('slug',$input['slug'])->first();

		if($exist){
			return $this->error_back('已存在相同纪录，请修改后重新提交！');
		}

		if($input['level']>=config('admin.superadmin_level')){
			return $this->error_back('级别必须小于'.config('admin.superadmin_level'));
		}

		$response=Role::create($input);

		if(!$response){

			return $this->error_back(trans('admin.store_error_msg'));
		}

		return redirect('manage/role');



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
		$role=Role::find($id);

		if($role->level==config('admin.superadmin_level')){
			return $this->error_back(trans('admin.no_permission'));
		}


		return view($this->view,compact('role'));
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
		$role = Role::find($id);

		if($role->level==config('admin.superadmin_level')){
			return $this->error_back(trans('admin.no_permission'));
		}

		if(!$role){
			return $this->error_back(trans('admin.not_exist_msg'));
		}

		$input=$request->all();


		$exist = Role::where('id','<>',$id)
					->where(function($query) use($input){
						$query->where('name',$input['name'])
							  ->orWhere('slug',$input['slug']);
					})->first();

		if($exist){
			return $this->error_back(trans('admin.exist_msg'));
		}

		$response=$role->update($input);

		if(!$response){

			return $this->error_back(trans('admin.update_error_msg'));
		}

		return redirect('manage/role');

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$role_id = $id ;

		$role = Role::find($role_id);

		if($role->level==config('admin.superadmin_level')){
			return response([
				'status'=>0,
				'info'  =>trans('admin.no_permission')
			]);
		}

		if(!$role){
			return response([
				'status'=>0,
				'info'  =>trans('admin.not_exist_msg')
			]);
		}


		\DB::beginTransaction();

		//删除用户角色
		$roleUsers = $role->users()->get();

		foreach($roleUsers as $ru){
			$ru->detachRole($role);
		}

		//删除角色权限
		$permissionRole = $role->detachAllPermissions();

		//删除角色
		$deleteRole = $role->delete();

		if($deleteRole===false){
			\DB::rollback();
			return response([
				'status'=>0,
				'info'  =>trans('admin.destroy_error_msg')
			]);
		}

		\DB::commit();

		return response([
			'status'=>1,
			'info'  =>'删除成功！'
		]);
	}
}
