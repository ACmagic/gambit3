<?php namespace Modules\Customer\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Customer\Contracts\Context\Customer as CustomerContract;

class Customer extends Facade {

    protected static function getFacadeAccessor() {
        return CustomerContract::class;
    }

}