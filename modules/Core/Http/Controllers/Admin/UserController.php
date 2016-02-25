<?php

namespace Modules\Core\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Doctrine\ORM\EntityManagerInterface;

class UserController extends Controller
{

    protected $em;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(EntityManagerInterface $em)
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->em = $em;

        // middleware to require login

    }

    public function getList() {

        $user = $this->em->find('Modules\Core\Entities\User',1);

        return view('core::admin.user.list',['user'=>$user]);

    }

}
