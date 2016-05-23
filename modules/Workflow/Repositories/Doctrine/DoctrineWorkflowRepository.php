<?php namespace Modules\Workflow\Repositories\Doctrine;

use Modules\Workflow\Repositories\WorkflowRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineWorkflowRepository implements WorkflowRepository {

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