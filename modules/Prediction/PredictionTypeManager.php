<?php namespace Modules\Prediction;

use Modules\Prediction\Entities\Prediction as PredictionEntity;

class PredictionTypeManager {

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
     * @param PredictionEntity $prediction
     *   The prediction entity
     *
     * @return PredictionType
     */
    public function getTypeByEntity(PredictionEntity $prediction) : PredictionType {

        foreach($this->types as $type) {

            if($type->owns($prediction)) {
                return $type;
            }

        }

    }

}