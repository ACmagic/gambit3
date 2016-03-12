<?php namespace Modules\Core\Repositories;

interface SiteRepository {

    public function findById($id);
    public function findAll();
    public function findByStoreId($storeId);
    public function findByMachineName($machineName);
    public function createQueryBuilderForAdminDataGrid();

}