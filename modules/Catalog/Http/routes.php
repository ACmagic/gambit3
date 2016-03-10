<?php

Route::group(['middleware' => ['web','auth.admin']], function () {

	Route::get('/admin/lines','Modules\Catalog\Http\Controllers\Admin\LineController@getIndex');

});