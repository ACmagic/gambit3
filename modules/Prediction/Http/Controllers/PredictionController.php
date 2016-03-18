<?php namespace Modules\Prediction\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class PredictionController extends Controller {
	
	public function index()
	{
		return view('prediction::index');
	}
	
}