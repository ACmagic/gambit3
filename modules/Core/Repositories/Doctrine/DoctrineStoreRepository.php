<?php namespace Modules\Core\Repositories\Doctrine;

use Modules\Core\Repositories\StoreRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineStoreRepository implements StoreRepository {

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

    public function findByMachineName($machineName) {
        return $this->genericRepository->findOneByMachineName($machineName);
    }

}