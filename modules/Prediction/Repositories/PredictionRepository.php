<?php namespace Modules\Prediction\Repositories;

interface PredictionRepository {

    public function findById($id);
    public function findAll();

}