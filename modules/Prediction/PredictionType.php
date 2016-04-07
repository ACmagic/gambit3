<?php namespace Modules\Prediction;

interface PredictionType {

    public function getName();

    /**
     * @return CompatibilityResolver
     */
    public function getCompatibilityResolver();

}