<?php

/*Route::group(['middleware' => 'web', 'prefix' => 'core', 'namespace' => 'Modules\Core\Http\Controllers'], function()
{
	Route::get('/', 'CoreController@index');
});*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/admin/login','Modules\Core\Http\Controllers\Admin\AuthController@getLogin');
    Route::post('/admin/login','Modules\Core\Http\Controllers\Admin\AuthController@postLogin');

});

Route::group(['middleware' => ['web','auth.admin']], function () {

    //Route::get('/admin/auth','Modules\Core\Http\Controllers\Admin\AuthController@getRegister');
    //Route::post('/admin/auth','Modules\Core\Http\Controllers\Admin\AuthController@postRegister');
    Route::get('/admin/logout','Modules\Core\Http\Controllers\Admin\AuthController@getLogout');
    Route::get('/admin','Modules\Core\Http\Controllers\Admin\HomeController@getIndex');
    Route::get('/admin/users','Modules\Core\Http\Controllers\Admin\UserController@getIndex');
    Route::get('/admin/sites','Modules\Core\Http\Controllers\Admin\SiteController@getIndex');
    Route::get('/admin/stores','Modules\Core\Http\Controllers\Admin\StoreController@getIndex');

});