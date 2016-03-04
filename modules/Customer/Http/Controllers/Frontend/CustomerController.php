<?php

namespace Modules\Customer\Http\Controllers\Frontend;

use Modules\Core\Http\Controllers\Frontend\AbstractBaseController;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Modules\Core\Facades\Store;

class CustomerController extends AbstractBaseController
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    // Location to redirect to after successful login.
    protected $redirectTo = '/profile';

    // Set view used for login action.
    protected $loginView = 'customer::frontend.customer.login';

    // Set view used for registration action.
    protected $registerView = 'customer::frontend.customer.register';

    // The guard
    protected $guard = 'customers';

    public function getIndex() {

        echo Store::getStoreId();

        return view('customer::frontend.customer.index');

    }

}
