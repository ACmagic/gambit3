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

    Route::get('/lines/{type}/{id}',[
        'uses'=> 'Modules\Catalog\Http\Controllers\Frontend\LineController@getIndex',
        'as'=> 'lines',
    ]);

    Route::get('/category/{categoryId}','Modules\Catalog\Http\Controllers\Frontend\CategoryController@getIndex');

    Route::get('line/{lineId}/accept',[
        'uses'=> 'Modules\Catalog\Http\Controllers\Frontend\LineController@getAccept',
        'as'=> 'line.accept'
    ]);

    Route::post('line/{lineId}/accept',[
        'uses'=> 'Modules\Catalog\Http\Controllers\Frontend\LineController@postAccept',
        'as'=> 'line.accept.post'
    ]);

    Route::get('api/category/{categoryId}','Modules\Catalog\Http\Controllers\Api\CategoryController@getIndex');

});

// Api
Route::group(['middleware' => ['api']], function () {

    Route::get('/api/category/{categoryId}/events','Modules\Catalog\Http\Controllers\Api\CategoryController@getEvents');

});