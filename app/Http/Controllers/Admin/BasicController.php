<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class BasicController extends Controller
{
    protected $view;


    public function __construct ()
    {
        $this->view=$this->getView();

        static::check_permission();

    }

    protected function check_permission(){
        if( Auth::check() && Auth::user()->level() != config('admin.superadmin_level')){
            $this->method_permission();
        }
    }

    protected function method_permission(){}


    public function error_back($error)
    {
        if(Request::ajax()){
            return response([
                'status'=>0,
                'info'  =>$error
            ]);
        }else{
            return redirect()->back()->withInput()->withErrors($error);
        }
    }

    /**
     * 得到模板路径
     *
     * @return string admin.brand.create
     */
    protected function getView()
    {
        return strtolower($this->getCurrentModuleName()).'.'.
               strtolower($this->getCurrentControllerName()).'.'.
               strtolower($this->getCurrentMethodName());
    }

    /**
     * 得到当前模块名
     *
     * @return mixed admin
     */
    protected function getCurrentModuleName()
    {
        return $this->getCurrentAction()['module'];
    }

    /**
     * 获取当前控制器名
     *
     * @return string brand
     */
    protected function getCurrentControllerName()
    {
        return $this->getCurrentAction()['controller'];
    }

    /**
     * 获取当前方法名
     *
     * @return string create
     */
    protected function getCurrentMethodName()
    {
        return $this->getCurrentAction()['method'];
    }

    /**
     * 获取当前控制器与方法
     *
     * @return array
     */
    protected function getCurrentAction()
    {
        $action = \Route::current()->getActionName();
        list($class, $method) = explode('@', $action);
        list($app,$http,$controllers,$module,$controller)=explode('\\',$class);
        return ['module'=>$module,'controller' => explode('Controller',$controller)[0], 'method' => $method];
    }



}