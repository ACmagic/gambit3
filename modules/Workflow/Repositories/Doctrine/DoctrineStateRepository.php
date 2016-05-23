<?php namespace Modules\Workflow\Repositories\Doctrine;

use Modules\Workflow\Repositories\StateRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineStateRepository implements StateRepository {

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