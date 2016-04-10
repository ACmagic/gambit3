<?php namespace Modules\Checkout\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Checkout\Contracts\Context\Cart as CartContract;

class Cart extends Facade {

    protected static function getFacadeAccessor() {
        return CartContract::class;
    }

}