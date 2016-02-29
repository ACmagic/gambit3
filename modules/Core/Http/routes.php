<?php

/*Route::group(['middleware' => 'web', 'prefix' => 'core', 'namespace' => 'Modules\Core\Http\Controllers'], function()
{
	Route::get('/', 'CoreController@index');
});*/

Route::group(['middleware' => ['web']], function () {

    Route::get('/admin/auth','Modules\Core\Http\Controllers\Admin\AuthController@getRegister');
    Route::post('/admin/auth','Modules\Core\Http\Controllers\Admin\AuthController@postRegister');
    Route::get('/admin/users','Modules\Core\Http\Controllers\Admin\UserController@getList');
    Route::get('/admin/sites','Modules\Core\Http\Controllers\Admin\SiteController@getIndex');

});