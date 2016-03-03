<?php

namespace Modules\Customer\Http\Controllers\Frontend;

use Modules\Core\Http\Controllers\Frontend\AbstractBaseController;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class CustomerController extends AbstractBaseController
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    // Location to redirect to after successful login.
    protected $redirectTo = '/user/dashboard';

    // Set view used for login action.
    protected $loginView = 'customer::frontend.customer.login';

    // Set view used for registration action.
    protected $registerView = 'customer::frontend.customer.register';

    // The guard
    protected $guard = 'customers';

    public function getIndex() {

        return view('customer::frontend.customer.index');

    }

}
