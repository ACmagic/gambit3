<?php namespace Modules\Prediction;

trait CompatibilityResolverTrait {

    protected $predictable;

    public function setPredictable(Predictable $predictable) {
        $this->predictable = $predictable;
    }

}