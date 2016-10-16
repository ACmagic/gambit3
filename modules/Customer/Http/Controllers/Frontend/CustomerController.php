<?php

namespace Modules\Customer\Http\Controllers\Frontend;

use Modules\Core\Http\Controllers\Frontend\AbstractBaseController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Modules\Core\Facades\Store;
use Illuminate\Support\Facades\Auth;

class CustomerController extends AbstractBaseController
{

    use AuthenticatesUsers, RegistersUsers;

    use RedirectsUsers {
        RedirectsUsers::redirectPath insteadof AuthenticatesUsers;
        RedirectsUsers::redirectPath insteadof RegistersUsers;
    }

    // Location to redirect to after successful login.
    protected $redirectTo = '/profile';

    // Set view used for login action.
    protected $loginView = 'customer::frontend.customer.login';

    // Set view used for registration action.
    protected $registerView = 'customer::frontend.customer.register';

    // The guard
    protected $guard = 'customers';

    public function getIndex() {

        //echo Store::getStoreId();

        return view('customer::frontend.customer.index');

    }

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

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm() {
        return view($this->registerView);
    }

}
