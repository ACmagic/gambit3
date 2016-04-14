<?php namespace Modules\Accounting\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class AccountingController extends Controller {
	
	public function index()
	{
		return view('accounting::index');
	}
	
}