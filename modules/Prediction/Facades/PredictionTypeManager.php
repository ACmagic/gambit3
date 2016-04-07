<?php namespace Modules\Prediction\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Prediction\Contracts\PredictionTypeManager as IPredictionTypeManager;

class PredictionTypeManager extends Facade {

    protected static function getFacadeAccessor() {
        return IPredictionTypeManager::class;
    }

}