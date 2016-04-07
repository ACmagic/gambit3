<?php namespace Modules\Prediction\Contracts;

use Modules\Prediction\Predictable;

interface PredictionTypeManager {

    public function getTypes(Predictable $predictable);
    public function getType($name);

}