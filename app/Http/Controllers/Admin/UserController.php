<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Bican\Roles\Models\Permission;
use Bican\Roles\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class UserController extends BasicController
{
    protected function method_permission()
    {
        $this->middleware('level:100');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //获取管理员列表

        $input = [
            'keyword' => $request->input('keyword',''),
        ];


        //条件
        $where = '';
        if($input['keyword']){
            $where.= " and ( name like '%{$input['keyword']}%' ) ";
        }


        $users = User::whereRaw(" 1 ".$where)->orderBy('created_at','desc')->paginate(config('admin.show_pages'));

        $users->transform(function($v){

            $v->role = $v->roles->first();

            return $v;
        });


        return view($this->view,compact('users','input'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //查询所有可用角色
        $roles = Role::where('level','<>',config('admin.superadmin_level'))->get();

        return view($this->view,compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input=$request->except('role_id');
        $role_id = $request->input('role_id');
        //判断是否管理与重复

        $exist = User::where('name',$input['name'])->first();

        if($exist){
            return $this->error_back(trans('admin.exist_msg'));
        }

        if(!$input['name'] || !$role_id || !$input['password']){
            return $this->error_back(trans('admin.miss_param'));
        }

        //判断角色是否存在

        $role = Role::find($role_id);

        if(!$role){
            return $this->error_back('角色不存在！');
        }

        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        if(!$user){
            return $this->error_back(trans('admin.store_error_msg'));
        }

        //绑定管理员与角色

        $user->attachRole($role);

        return redirect('manage/user');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        echo 'show';
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user=User::find($id);

        //查询所有可用角色
        $roles = Role::where('level','<>',config('admin.superadmin_level'))->get();

        //获取所有顶级权限
        $user->role = $user->roles->first();

        return view($this->view,compact('user','roles'));
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
        //
        $user = User::find($id);

        if(!$user){
            return $this->error_back(trans('admin.not_exist_msg'));
        }

        $input=$request->except(['role_id','password']);
        $role_id = $request->input('role_id');
        $password = $request->input('password');

        $exist = User::where('id','<>',$id)
            ->where('name',$input['name'])
            ->first();

        if($exist){
            return $this->error_back(trans('admin.exist_msg'));
        }

        //如果有传新的密码，则修改
        if($password){
            $input['password'] = bcrypt($password);
        }

        $response=$user->update($input);

        //判断角色绑定是否修改
        $role = Role::find($role_id);

        if(!$role){
            return $this->error_back('角色不存在！');
        }

        $exist_user_role = $user->roles->first();
        if($exist_user_role){
            if($exist_user_role->pivot->role_id!=$role_id){
                //删除原来绑定，新增绑定
                $user->detachAllRoles();
                $user->attachRole($role);
            }
        }else{
            $user->attachRole($role);
        }

        if(!$response){

            return $this->error_back(trans('admin.update_error_msg'));
        }

        return redirect('manage/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_id = $id ;

        $user = User::find($user_id);

        if(!$user){
            return response([
                'status'=>0,
                'info'  =>trans('admin.not_exist_msg')
            ]);
        }

        //如果是超级管理员，不能删
        if($user->level() == config('admin.superadmin_level')){
            return response([
                'status'=>0,
                'info'  =>trans('admin.destroy_error_msg')
            ]);
        }

        \DB::beginTransaction();

        //删除管理员角色
        $deleteUserRoles = $user->detachAllRoles();

        if($deleteUserRoles===false){
            return response([
                'status'=>0,
                'info'  =>trans('admin.destroy_error_msg')
            ]);
        }

        //删除管理员
        $deleteUser = $user->delete();

        if($deleteUser===false){

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
