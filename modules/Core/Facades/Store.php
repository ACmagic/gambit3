<?php namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Core\Contracts\Context\Store as StoreContract;

class Store extends Facade {

    protected static function getFacadeAccessor() {
        return StoreContract::class;
    }

}