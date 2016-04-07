<?php namespace Modules\Vegas\Prediction\Type;

use Modules\Prediction\PredictionType;
use Modules\Vegas\Prediction\Compatibility\MoneyLineResolver;

class MoneyLineType implements PredictionType {

    public function getName() {
        return 'vegas_money_line';
    }
    
    public function getCompatibilityResolver() {
        return new MoneyLineResolver();
    }

}