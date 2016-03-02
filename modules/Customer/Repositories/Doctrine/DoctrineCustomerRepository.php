<?php namespace Modules\Customer\Repositories\Doctrine;

use Modules\Customer\Repositories\CustomerRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineCustomerRepository implements CustomerRepository {

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