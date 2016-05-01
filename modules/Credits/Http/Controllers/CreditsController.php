<?php namespace Modules\Credits\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class CreditsController extends Controller {
	
	public function index()
	{
		return view('credits::index');
	}
	
}