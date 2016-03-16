<?php

Route::group(['middleware' => 'web', 'prefix' => 'football', 'namespace' => 'Modules\Football\Http\Controllers'], function()
{
	Route::get('/', 'FootballController@index');
});