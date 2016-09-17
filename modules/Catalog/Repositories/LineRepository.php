<?php namespace Modules\Catalog\Repositories;

use Modules\Catalog\Entities\Line as LineEntity;

interface LineRepository {

    public function findById($id);
    public function findAll();
    public function createQueryBuilderForAdminDataGrid();
    public function matchOpenLine(LineEntity $line);
    public function recomputeCalculatedValues(LineEntity $line);

    // Cached aggregate calculations
    public function calculateRollingInventory(LineEntity $line) : int;
    public function calculateRollingAmount(LineEntity $line);
    public function calculateRollingAmountMax(LineEntity $line);
    public function calculateRealTimeInventory(LineEntity $line) : int;
    public function calculateRealTimeAmount(LineEntity $line);
    public function calculateRealTimeAmountMax(LineEntity $line);

}