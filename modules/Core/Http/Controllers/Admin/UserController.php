<?php

namespace Modules\Core\Http\Controllers\Admin;

use Modules\Core\Repositories\UserRepository;

class UserController extends AbstractBaseController
{

    protected $userRepository;

    /**
     * Create a new authentication controller instance.
     *
     * @param UserRepository $userRepository
     *   The user repository.
     */
    public function __construct(UserRepository $userRepository)
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->userRepository = $userRepository;

        // middleware to require login

    }

    public function getIndex() {

        //$user = $this->em->find('Modules\Core\Entities\User',1);
        return view('core::admin.user.index');

    }

}
