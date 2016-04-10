<?php

Route::group(['middleware' => 'web', 'prefix' => 'checkout', 'namespace' => 'Modules\Checkout\Http\Controllers'], function()
{
	Route::get('/', 'CheckoutController@index');
});