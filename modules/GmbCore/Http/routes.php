<?php

Route::group(['middleware' => 'web', 'prefix' => 'gmbcore', 'namespace' => 'Modules\GmbCore\Http\Controllers'], function()
{
	Route::get('/', 'GmbCoreController@index');
});