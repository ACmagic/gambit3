<?php namespace Modules\Accounting\Repositories\Doctrine;

use Modules\Accounting\Repositories\AccountTypeRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineAccountTypeRepository implements AccountTypeRepository {

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

    public function findExternalType() {
        return $this->genericRepository->findOneByMachineName(AccountTypeRepository::TYPE_EXTERNAL);
    }

    public function findInternalType() {
        return $this->genericRepository->findOneByMachineName(AccountTypeRepository::TYPE_INTERNAL);
    }

}