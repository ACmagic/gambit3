<?php namespace Modules\Prediction\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Prediction\Contracts\PredictableManager as IPredictableManager;

class PredictableManager extends Facade {

    protected static function getFacadeAccessor() {
        return IPredictableManager::class;
    }

}