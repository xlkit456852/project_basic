<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//设置使用中文语言包
\Illuminate\Support\Facades\App::setLocale('zh_cn');

//后台
Route::group(['prefix' =>'manage', 'namespace' =>'Admin'], function() {
    Route::group(['middleware'=>'auth'], function () {
        include 'routes/admin.php';
    });

    //后台登录
    Route::get('login', 'LoginController@login');
    Route::get('logout','LoginController@logout');
    Route::post('login','LoginController@postLogin');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

//Route::group(['middleware' => ['web']], function () {
//
//});
