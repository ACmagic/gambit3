<?php namespace Modules\Event\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class EventController extends Controller {
	
	public function index()
	{
		return view('event::index');
	}
	
}