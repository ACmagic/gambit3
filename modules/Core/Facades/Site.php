<?php namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Core\Contracts\Context\Site as SiteContract;

class Site extends Facade {

    protected static function getFacadeAccessor() {
        return SiteContract::class;
    }

}