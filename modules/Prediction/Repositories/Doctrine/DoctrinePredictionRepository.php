<?php namespace Modules\Prediction\Repositories\Doctrine;

use Modules\Prediction\Repositories\PredictionRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrinePredictionRepository implements PredictionRepository {

    protected $genericRepository;

    public function __construct(ObjectRepository $genericRepository) {
        $this->genericRepository = $genericRepository;
    }

    public function findById($id) {
        return $this->genericRepository->find($id);
    }

    public function findAll() {
        return $this->genericRepository->findAll();
    }

}