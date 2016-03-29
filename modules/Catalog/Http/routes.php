<?php

// admin
Route::group(['middleware' => ['web','auth.admin']], function () {

	Route::get('/admin/lines','Modules\Catalog\Http\Controllers\Admin\LineController@getIndex');
	Route::get('/admin/advertised-lines','Modules\Catalog\Http\Controllers\Admin\AdvertisedLineController@getIndex');
	Route::get('/admin/accepted-lines','Modules\Catalog\Http\Controllers\Admin\AcceptedLineController@getIndex');

});

// Frontend
Route::group(['middleware' => ['web']], function () {

	Route::get('/advertise-line/{event}','Modules\Catalog\Http\Controllers\Frontend\AdvertisedLineController@getIndex');

});