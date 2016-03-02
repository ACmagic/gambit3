<?php

/*Route::group(['middleware' => 'web', 'prefix' => 'core', 'namespace' => 'Modules\Core\Http\Controllers'], function()
{
	Route::get('/', 'CoreController@index');
});*/

Route::group(['middleware' => ['web']], function () {

	Route::get('/admin/customers','Modules\Customer\Http\Controllers\Admin\CustomerController@getIndex');

});