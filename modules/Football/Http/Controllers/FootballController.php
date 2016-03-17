<?php namespace Modules\Football\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class FootballController extends Controller {
	
	public function index()
	{
		return view('football::index');
	}
	
}