<?php namespace Modules\Prediction\Contracts;

use Modules\Prediction\Predictable;
use Modules\Prediction\Entities\Prediction as PredictionEntity;
use Modules\Prediction\PredictionType;

interface PredictionTypeManager {

    public function getTypes(Predictable $predictable);
    public function getType($name);
    public function getTypeByEntity(PredictionEntity $prediction) : PredictionType;

}