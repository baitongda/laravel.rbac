<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//前台路由
Route::get('/','Home\IndexController@index');



//后台路由
Route::group(['prefix' => 'admin','middleware' => 'web','namespace' => 'Admin'], function () {

	Route::get('/','IndexController@index');

	Route::get('/index/main','IndexController@main');
	Route::get('/index/left/{id}','IndexController@left');

	Route::get('/public/verify','PublicController@verify');
    Route::get('/public/test','PublicController@test');


	Route::get('/login/index','LoginController@index');
	Route::get('/login','LoginController@index');
	Route::post('/login/checkLogin','LoginController@checkLogin');

    Route::get('/login/logout','LoginController@logout');

    Route::get('/node/index','NodeController@index');
    Route::any('/node/add/{pid?}','NodeController@add');
    Route::any('/node/edit/{id?}/{pid?}','NodeController@edit');

	Route::any('/node/del/{id?}','NodeController@del');

	Route::post('/node/sort','NodeController@sort');

	//清除缓存路由
	Route::get('/cache/delcore','CacheController@delCore');

	//后台用户路由
	Route::get('/user/index','UserController@index');
	Route::any('/user/del/{id?}','UserController@del');
	Route::any('user/add','UserController@add');
	Route::any('user/edit/{id?}','UserController@edit');
	Route::any('/user/check_username/{userid?}','UserController@check_username');
	Route::any('/user/role',"UserController@role");
	Route::post('/user/role_sort',"UserController@role_sort");
	Route::any('/user/role_add',"UserController@role_add");
	Route::any('/user/role_edit/{id?}',"UserController@role_edit");
	Route::any('/user/role_del/{id?}',"UserController@role_del");

	Route::any('/user/access/{roleid?}',"UserController@access");
	Route::any('/user/access_edit',"UserController@access_edit");

	Route::get('/config/conf/id/{id?}', 'ConfigController@config');//网站信息视图
	Route::post('/config/updateweb','ConfigController@updateweb');//网站信息设置


});