<?php namespace Modules\Vegas\Prediction\Type;

use Modules\Prediction\PredictionType;
use Modules\Vegas\Prediction\Compatibility\PointSpreadResolver;

class PointSpreadType implements PredictionType {
    
    public function getName() {
        return 'vegas_point_spread';
    }

    public function getCompatibilityResolver() {
        return new PointSpreadResolver();
    }
    
}