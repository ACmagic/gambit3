<?php

Route::group(['middleware' => 'web', 'prefix' => 'workflow', 'namespace' => 'Modules\Workflow\Http\Controllers'], function()
{
	Route::get('/', 'WorkflowController@index');
});