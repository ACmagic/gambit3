<?php

Route::group(['middleware' => ['web']], function () {

    Route::get('credits/add',[
        'uses'=> 'Modules\Credits\Http\Controllers\Frontend\CreditsController@getAddCredits',
        'as'=> 'credits.add',
    ]);

    Route::post('credits/add',[
        'uses'=> 'Modules\Credits\Http\Controllers\Frontend\CreditsController@postAddCredits',
        'as'=> 'credits.add.post',
    ]);

});