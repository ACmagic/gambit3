<?php namespace Modules\Accounting\Repositories\Doctrine;

use Modules\Accounting\Repositories\AssetTypeRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Modules\Accounting\Entities\AssetType as AssetTypeEntity;

class DoctrineAssetTypeRepository implements AssetTypeRepository {

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

    /**
     * @return AssetType
     */
    public function findUsdAssetType() {
        return $this->genericRepository->findOneByMachineName(AssetTypeEntity::TYPE_USD);
    }

    /**
     * @return AssetType
     */
    public function findCreditAssetType() {
        return $this->genericRepository->findOneByMachineName(AssetTypeEntity::TYPE_CREDIT);
    }

}