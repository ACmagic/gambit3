<?php namespace Modules\Gmbcore\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class GmbCoreController extends Controller {
	
	public function index()
	{
		return view('gmbcore::index');
	}
	
}