<?php namespace Modules\Prediction;

interface PredictableResolver {

    public function getName();
    public function getById($id);
    public function owns(Predictable $predictable);
    public function pluckId(Predictable $predictable);

}