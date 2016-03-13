<?php namespace Modules\Catalog\Repositories\Doctrine;

use Modules\Catalog\Repositories\LineRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineLineRepository implements LineRepository {

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

    public function createQueryBuilderForAdminDataGrid() {

        $qb = $this->genericRepository->createQueryBuilder('l');
        $qb->select('l','s');
        $qb
            ->join('l.store','s');

        return $qb;

    }

}