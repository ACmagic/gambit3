<?php

Route::group(['middleware' => ['web']], function () {

	Route::get('events','Modules\Event\Http\Controllers\Frontend\EventController@getList');

});

Route::group(['middleware' => ['web','auth.admin']], function () {

	Route::get('admin/categories','Modules\Event\Http\Controllers\Admin\CategoryController@getIndex');
	Route::get('admin/events','Modules\Event\Http\Controllers\Admin\EventController@getIndex');
	Route::get('admin/competitors','Modules\Event\Http\Controllers\Admin\CompetitorController@getIndex');

});

// Api
Route::group(['middleware' => ['api']], function () {

    Route::get('/api/event/category/{categoryId}','Modules\Event\Http\Controllers\Api\CategoryController@getIndex');

});