<?php namespace Modules\Sales\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class SalesController extends Controller {
	
	public function index()
	{
		return view('sales::index');
	}
	
}