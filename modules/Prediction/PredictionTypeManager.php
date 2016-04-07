<?php namespace Modules\Prediction;

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

}