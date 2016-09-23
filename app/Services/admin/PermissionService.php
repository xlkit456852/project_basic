<?php
namespace App\Services\admin;

use Bican\Roles\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionService{

	public function changeYesOrNo($permission_id,$request)
	{
		$f = $request->input('fle','');
		$v = $request->input('yesno',0);

		if($f && $permission_id){
			$permission = Permission::find($permission_id);
			if(!$permission){
				return response([
					'status'=>0,
					'info'  =>trans('admin.update_error_msg')
				]);
			}
			$update = $permission->update([$f=>$v]);

			return response([
				'status'=>1,
				'info'  =>trans('admin.update_success_msg')
			]);
		}else{
			return response([
				'status'=>0,
				'info'  =>trans('admin.update_error_msg')
			]);
		}
	}
	

}