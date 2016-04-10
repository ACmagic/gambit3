<?php namespace Modules\Checkout\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class CheckoutController extends Controller {
	
	public function index()
	{
		return view('checkout::index');
	}
	
}