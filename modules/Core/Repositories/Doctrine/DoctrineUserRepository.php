<?php namespace Modules\Core\Repositories\Doctrine;

use Modules\Core\Repositories\UserRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineUserRepository implements UserRepository {

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

        $qb = $this->genericRepository->createQueryBuilder('u');
        return $qb;

    }

}