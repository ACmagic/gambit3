<?php

namespace Modules\Core\Http\Controllers\Admin;

use Modules\Core\Repositories\UserRepository;
use Illuminate\Foundation\Auth\RegistersUsers;
use Modules\Core\Entities\User as UserEntity;
use Validator;
use Doctrine\ORM\EntityManagerInterface;
use Carbon\Carbon;

class UserController extends AbstractBaseController
{

    use RegistersUsers;

    protected $userRepository;
    protected $em;
    protected $guard = 'users';
    protected $registerView = 'core::admin.user.create';
    protected $redirectPath = 'admin/users';

    /**
     * Create a new authentication controller instance.
     *
     * @param UserRepository $userRepository
     *   The user repository.
     *
     * @param EntityManagerInterface $em
     *   The entity manager.
     */
    public function __construct(UserRepository $userRepository,EntityManagerInterface $em)
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->userRepository = $userRepository;
        $this->em = $em;

        // middleware to require login

    }

    public function getIndex() {

        //$user = $this->em->find('Modules\Core\Entities\User',1);
        return view('core::admin.user.index');

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
            'email' => 'required|email|max:128|unique:'.UserEntity::class,
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data) {

        $user = new UserEntity();
        $user->setEmail($data['email']);
        $user->setPassword(bcrypt($data['password']));
        $user->setCreatedAt(Carbon::now());
        $user->setUpdatedAt(Carbon::now());

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

}
