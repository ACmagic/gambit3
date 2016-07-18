<?php namespace Modules\Catalog\Repositories;

use Modules\Catalog\Entities\Line as LineEntity;

interface LineRepository {

    public function findById($id);
    public function findAll();
    public function createQueryBuilderForAdminDataGrid();
    public function matchOpenLine(LineEntity $line);

}