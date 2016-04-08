<?php namespace Modules\Prediction\Contracts;

use Modules\Prediction\Predictable;

interface PredictableManager {

    public function getPredictable($name,$id);
    public function getResolver($name);
    public function matchResolver(Predictable $predictable);

}