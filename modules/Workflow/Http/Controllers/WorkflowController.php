<?php namespace Modules\Workflow\Http\Controllers;

use Pingpong\Modules\Routing\Controller;

class WorkflowController extends Controller {
	
	public function index()
	{
		return view('workflow::index');
	}
	
}