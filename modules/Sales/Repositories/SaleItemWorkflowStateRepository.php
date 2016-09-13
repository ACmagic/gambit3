<?php namespace Modules\Sales\Repositories;

use Modules\Workflow\Repositories\StateRepository;
use Modules\Sales\Entities\SaleItemWorkflowState;

interface SaleItemWorkflowStateRepository extends StateRepository {

    /**
     * Get paid state.
     *
     * @return SaleItemWorkflowState
     */
    public function findPaidState() : SaleItemWorkflowState;

}