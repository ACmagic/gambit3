<?php

/*Route::group(['middleware' => 'web', 'prefix' => 'core', 'namespace' => 'Modules\Core\Http\Controllers'], function()
{
	Route::get('/', 'CoreController@index');
});*/

Route::group(['middleware' => ['web']], function () {

	Route::get('login','Modules\Customer\Http\Controllers\Frontend\CustomerController@showLoginForm');
	Route::post('login','Modules\Customer\Http\Controllers\Frontend\CustomerController@login');

});

Route::group(['middleware' => ['web','auth.customer']], function () {

	Route::get('logout','Modules\Customer\Http\Controllers\Frontend\CustomerController@logout');
	Route::get('profile','Modules\Customer\Http\Controllers\Frontend\CustomerController@getIndex');

});

Route::group(['middleware' => ['web','auth.admin']], function () {

	Route::get('admin/customers','Modules\Customer\Http\Controllers\Admin\CustomerController@getIndex');
	Route::post('admin/customers','Modules\Customer\Http\Controllers\Admin\CustomerController@getIndex');

});