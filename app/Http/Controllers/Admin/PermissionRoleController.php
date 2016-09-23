<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

use App\Http\Requests;

class PermissionRoleController extends BasicController
{
	public function method_permission()
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

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{


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
	public function edit($id,Request $request)
	{
		$role = Role::find($id);

		if($role->level==config('admin.superadmin_level')){
			return $this->error_back(trans('admin.no_permission'));
		}

		//所有顶级权限
		$permissions=Permission::where('parent_id',0)->get();

		//角色权限
		$rolePermissions = $role->permissions()->orderBy('sort_order')->orderBy('id')->get();



		//角色权限字符串（方便判断是否含有权限）
		$permission_string = $rolePermissions->implode('slug', ',');

		$permissions->transform(function($v) use($permission_string){
			if(!(strpos($permission_string,$v->slug) === false)){
				$v->checked=1;
			}
			//子级权限
			$v->child = Permission::where('parent_id',$v->id)->get();
			$v->child->transform(function($cv) use($permission_string){
				if(!(strpos($permission_string,$cv->slug) === false)){
					$cv->checked=1;
				}
				return $cv;
			});
			return $v;
		});


		return view('admin.role.permission',compact('permissions','role'));
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

		//已选角色权限
		$input=$request->all();
		$choose_permissions = $input['permission_list'];

		$sync_permission = empty($choose_permissions) ? $role->detachAllPermission() : $role->permissions()->sync($choose_permissions);


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

	}
}
