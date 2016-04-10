<?php

Route::group(['middleware' => ['web']], function () {

	Route::get('prediction/new/{type}/{id}',[
		'uses'=> 'Modules\Prediction\Http\Controllers\Frontend\PredictionController@getNew',
		'as'=> 'prediction.new'
	]);

	Route::get('prediction/new/{type}/{id}/{predictionType}',[
		'uses'=> 'Modules\Prediction\Http\Controllers\Frontend\PredictionController@getNewConfigure',
		'as'=> 'prediction.new.configure'
	]);

	Route::post('prediction/new',[
		'uses'=> 'Modules\Prediction\Http\Controllers\Frontend\PredictionController@postNew',
		'as'=> 'prediction.add'
	]);

});