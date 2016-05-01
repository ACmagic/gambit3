<?php

Route::group(['middleware' => ['web']], function () {

	/*Route::get('checkout/credits',[
		'uses'=> 'Modules\Checkout\Http\Controllers\Frontend\CreditsController@getIndex',
		'as'=> 'checkout.credits',
	]);*/

	/*Route::post('checkout/credits',[
		'uses'=> 'Modules\Checkout\Http\Controllers\Frontend\CreditsController@postIndex',
		'as'=> 'checkout.credits.post',
	]);*/

	Route::get('checkout/gateway',[
		'uses'=> 'Modules\Checkout\Http\Controllers\Frontend\CheckoutController@getGateway',
		'as'=> 'checkout.gateway',
		'middleware'=> 'auth.customer',
	]);

	Route::post('checkout/gateway}',[
		'uses'=> 'Modules\Checkout\Http\Controllers\Frontend\CheckoutController@postGateway',
		'as'=> 'checkout.gateway.post',
		'middleware'=> 'auth.customer',
	]);

	Route::get('checkout/credits/done/{payum_token}',[
		'uses'=> 'Modules\Checkout\Http\Controllers\Frontend\CheckoutController@getDone',
		'as'=> 'checkout.done',
	]);

	// Indirect registration/authentication
	Route::get('checkout/login',[
		'uses'=> 'Modules\Checkout\Http\Controllers\Frontend\CheckoutController@getLogin',
		'as'=> 'checkout.login',
	]);

	Route::post('checkout/login',[
		'uses'=> 'Modules\Checkout\Http\Controllers\Frontend\CheckoutController@postLogin',
		'as'=> 'checkout.login.post',
	]);

	Route::get('checkout/register',[
		'uses'=> 'Modules\Checkout\Http\Controllers\Frontend\CheckoutController@getRegister',
		'as'=> 'checkout.register',
	]);

	Route::post('checkout/register',[
		'uses'=> 'Modules\Checkout\Http\Controllers\Frontend\CheckoutController@postRegister',
		'as'=> 'checkout.register.post',
	]);

});