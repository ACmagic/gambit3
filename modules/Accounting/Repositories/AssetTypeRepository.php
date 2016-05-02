<?php namespace Modules\Accounting\Repositories;

use Modules\Accounting\Entities\AssetType;

interface AssetTypeRepository {


    public function findById($id);
    public function findAll();

    /**
     * @return AssetType
     */
    public function findUsdAssetType();

    /**
     * @return AssetType
     */
    public function findCreditAssetType();

}