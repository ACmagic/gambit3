<?php namespace Modules\Prediction\Entities;

use Modules\Prediction\Contracts\Entities\Prediction as PredictionContract;
use Modules\Prediction\Facades\PredictionTypeManager;

abstract class Prediction implements \JsonSerializable, PredictionContract {

    use PredictionTrait;

    /**
     * Lifecycle callback to populate the inverse type.
     *
     * @return void
     */
    public function populateInverseType() {
        $inverseType = PredictionTypeManager::getTypeByEntity($this)->getInverseEntityClassName();
        $this->setInverseType($inverseType);
    }

}