<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\admin\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    //登录
    public function login()
    {

        if(Auth::check()){
            return redirect('manage');
        }else{
            return view('admin.admin.login');
        }

    }

    //登录验证
    public function postLogin(Request $request)
    {
        if(Auth::check()){
            return response([
                'status'=>0,
                'info'  =>'重复登录！'
            ]);
        }

        $name    =$request->input('name');
        $password=$request->input('password');

        if (!Auth::attempt(['name' =>$name, 'password' =>$password])){
            return response([
                'status'=>0,
                'info'  =>'登录失败！'
            ]);
        }

        //处理权限
        $this->loginService->initPermission($request);

        return response([
            'status'=>1,
            'info'  =>'登录成功！',
            'url'   =>url('manage')
        ]);
    }


    //登出
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->forget('user_permission');
        $request->session()->forget('permission_menu');
        //$request->session()->flush();
        return redirect('manage/login');
    }





}
