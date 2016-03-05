<?php namespace Modules\Customer\Repositories\Doctrine;

use Modules\Customer\Repositories\CustomerPoolRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineCustomerPoolRepository implements CustomerPoolRepository {

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

    public function findBySiteId($siteId) {
        return $this->genericRepository->findOneBy(['site'=>$siteId]);
    }

}