<?php namespace Modules\Prediction\Contracts;

interface PredictableManager {

    public function getPredictable($name,$id);
    public function getResolver($name);

}