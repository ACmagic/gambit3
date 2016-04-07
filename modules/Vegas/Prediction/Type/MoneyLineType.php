<?php namespace Modules\Vegas\Prediction\Type;

use Modules\Prediction\PredictionType;
use Modules\Vegas\Prediction\Compatibility\MoneyLineResolver;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Vegas\Prediction\Forms\MoneyLineForm;

class MoneyLineType implements PredictionType {

    protected $formBuilder;

    public function __construct(FormBuilder $formBuilder) {
        $this->formBuilder = $formBuilder;
    }

    public function getName() {
        return 'vegas_money_line';
    }
    
    public function getCompatibilityResolver() {
        return new MoneyLineResolver();
    }

    public function getFrontendTitle() {
        return 'Money Line';
    }

    public function getFrontendForm($args) {
        $form = $this->formBuilder->create(MoneyLineForm::class,$args);
        return $form;
    }

}