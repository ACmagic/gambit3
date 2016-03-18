<?php namespace Modules\Vegas\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class VegasController extends Controller {
	
	public function index()
	{
		return view('vegas::index');
	}
	
}