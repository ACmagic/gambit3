<?php

Route::group(['middleware' => ['web']], function () {

	Route::get('prediction/new/{type}/{id}',[
		'uses'=> 'Modules\Prediction\Http\Controllers\Frontend\PredictionController@getNew',
		'as'=> 'prediction.new'
	]);

});