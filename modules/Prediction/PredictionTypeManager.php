<?php namespace Modules\Prediction;

use Modules\Prediction\Contracts\Entities\Prediction as PredictionContract;
use Modules\Prediction\Contracts\PredictionTypeManager as PredictionTypeManagerContract;

class PredictionTypeManager implements PredictionTypeManagerContract {

    protected $types = [];

    public function __construct($types=[]) {

        foreach($types as $type) {
            $this->addType($type);
        }

    }

    public function addType(PredictionType $type) {
        $this->types[$type->getName()] = $type;
    }

    public function getType($name) {
        return $this->types[$name];
    }

    public function getTypes(Predictable $predictable) {

        $compatible = [];

        foreach($this->types as $type) {
            
            $compatibility = $type->getCompatibilityResolver();
            $compatibility->setPredictable($predictable);
            
            if($compatibility->isCompatible()) {
                $compatible[] = $type;
            }
        }

        return $compatible;

    }

    /**
     * Match prediction type by prediction entity instance.
     *
     * @param PredictionContract $prediction
     *   The prediction entity
     *
     * @return PredictionType
     */
    public function getTypeByEntity(PredictionContract $prediction) : PredictionType {

        foreach($this->types as $type) {

            if($type->owns($prediction)) {
                return $type;
            }

        }

    }

}