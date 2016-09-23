<?php
namespace App\Services\admin;

use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Auth;

class LoginService{

	/**
	 * 初始化权限
	 * @param $request
	 */
	public function initPermission($request)
	{
		$user = Auth::user();


		if($user->level()==config('admin.superadmin_level')){
			$user_rolePermissions = Permission::orderBy('sort_order')->orderBy('id')->get();
		}else{
			$user_rolePermissions = $user->rolePermissions()->orderBy('sort_order')->orderBy('id')->get();
		}


		//用户权限字符串（方便判断是否含有权限）
		$permission_string = $user_rolePermissions->implode('slug', ',');
		$request->session()->put('user_permission',$permission_string);

		//用户权限树，用于菜单显示

		$permission_tree = [];
		foreach($user_rolePermissions->toArray() as $up){
			if($up['parent_id'] ==0 && !isset($permission_tree[$up['id']])){
				$permission_tree[$up['id']] = $up;
				$permission_tree[$up['id']]['child'] = array();
			}else{
				$permission_tree[$up['parent_id']]['child'][]= $up ;
			}

		}


		$request->session()->put('permission_menu',$permission_tree);
	}

}