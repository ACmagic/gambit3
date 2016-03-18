<?php

Route::group(['middleware' => 'web', 'prefix' => 'prediction', 'namespace' => 'Modules\Prediction\Http\Controllers'], function()
{
	Route::get('/', 'PredictionController@index');
});