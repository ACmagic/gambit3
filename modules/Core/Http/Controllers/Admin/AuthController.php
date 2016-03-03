<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends AbstractBaseController
{

    use AuthenticatesUsers, ThrottlesLogins;

    // Location to redirect to after successful login.
    protected $redirectTo = '/admin';

    // Set view used for registration action.
    protected $loginView = 'core::admin.auth.login';

    // The guard
    protected $guard = 'users';

}
