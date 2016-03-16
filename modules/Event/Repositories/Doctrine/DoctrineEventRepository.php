<?php namespace Modules\Event\Repositories\Doctrine;

use Modules\Event\Repositories\EventRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineEventRepository implements EventRepository {

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