<?php namespace Modules\Prediction;

interface CompatibilityResolver {
    public function isCompatible();
    public function setPredictable(Predictable $predictable);
}