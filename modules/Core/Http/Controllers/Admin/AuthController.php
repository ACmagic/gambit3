<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class AuthController extends AbstractBaseController
{
    use AuthenticatesUsers;

    // Location to redirect to after successful login.
    protected $redirectTo = '/admin';

    // Set view used for registration action.
    protected $loginView = 'core::admin.auth.login';

    // The guard
    protected $guard = 'users';

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard() {
        return Auth::guard($this->guard);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm() {
        return view($this->loginView);
    }

}
