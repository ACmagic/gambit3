<?php namespace Modules\Prediction;

interface PredictableResolver {

    public function getName();
    public function getById($id);

}