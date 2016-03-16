<?php

Route::group(['middleware' => ['web','auth.admin']], function () {

	Route::get('admin/categories','Modules\Event\Http\Controllers\Admin\CategoryController@getIndex');
	Route::get('admin/events','Modules\Event\Http\Controllers\Admin\EventController@getIndex');

});