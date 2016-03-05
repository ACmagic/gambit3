<?php namespace Modules\Customer\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Customer\Contracts\Context\CustomerPool as CustomerPoolContract;

class CustomerPool extends Facade {

    protected static function getFacadeAccessor() {
        return CustomerPoolContract::class;
    }

}