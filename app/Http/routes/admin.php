<?php
//后台首页
Route::resource('/','AdminController');

//管理员管理
Route::resource('user','UserController');

//角色管理
Route::resource('role','RoleController');

//权限管理
Route::resource('permission','PermissionController');

//角色权限管理
Route::resource('permissionrole','PermissionRoleController');

