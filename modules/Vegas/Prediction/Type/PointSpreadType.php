<?php namespace Modules\Vegas\Prediction\Type;

use Modules\Prediction\PredictionType;
use Modules\Vegas\Prediction\Compatibility\PointSpreadResolver;
use Kris\LaravelFormBuilder\FormBuilder;
use Modules\Vegas\Prediction\Forms\PointSpreadForm;

class PointSpreadType implements PredictionType {

    protected $formBuilder;

    public function __construct(FormBuilder $formBuilder) {
        $this->formBuilder = $formBuilder;
    }

    public function getName() {
        return 'vegas_point_spread';
    }

    public function getCompatibilityResolver() {
        return new PointSpreadResolver();
    }

    public function getFrontendTitle() {
        return 'Point Spread';
    }

    public function getFrontendForm($args) {
        $form = $this->formBuilder->create(PointSpreadForm::class,$args);
        return $form;
    }
    
}