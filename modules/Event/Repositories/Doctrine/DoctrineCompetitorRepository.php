<?php namespace Modules\Event\Repositories\Doctrine;

use Modules\Event\Repositories\CompetitorRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineCompetitorRepository implements CompetitorRepository {

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