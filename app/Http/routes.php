<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

//后台路由
Route::any('admin/login', 'Admin\LoginController@login');
Route::get('admin/code', 'Admin\LoginController@code');
Route::group(['middleware' => ['admin.login'], 'prefix' => 'admin', 'namespace' => 'Admin'], function(){
    Route::get('/', 'IndexController@index');
    Route::get('logout', 'LoginController@logout');
    Route::get('welcome', 'WelcomeController@index');

    //清除缓存
    Route::get('cleanall', 'SettingController@cleanall');

    //网站管理
    Route::any('websetting', 'SettingController@websetting');
    Route::post('dodelweb', 'SettingController@dodelweb');
    Route::post('setting/doadd', 'SettingController@doadd');

    //日志管理
    Route::get('adminlogs', 'AdminLogsController@index');

    //管理员管理
    Route::resource('adminuser', 'AdminUserController');

    //权限管理
    Route::resource('auth', 'AuthController');

});