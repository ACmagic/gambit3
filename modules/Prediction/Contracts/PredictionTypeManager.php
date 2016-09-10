<?php namespace Modules\Prediction\Contracts;

use Modules\Prediction\Predictable;
use Modules\Prediction\PredictionType;
use Modules\Prediction\Contracts\Entities\Prediction as PredictionContract;

interface PredictionTypeManager {

    public function getTypes(Predictable $predictable);
    public function getType($name);
    public function getTypeByEntity(PredictionContract $prediction) : PredictionType;

}