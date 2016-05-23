<?php namespace Modules\Sales\Repositories;

use Modules\Workflow\Repositories\StateRepository;
use Modules\Sales\Entities\SaleWorkflowState;

interface SaleWorkflowStateRepository extends StateRepository {

    /**
     * Get paid state.
     *
     * @return SaleWorkflowState
     */
    public function findPaidState();

    /**
     * Get submitted state.
     *
     * @return SaleWorkflowState
     */
    public function findSubmittedState();

    /**
     * Get processing state.
     *
     * @return SaleWorkflowState
     */
    public function findProcessingState();

    /**
     * Get processed state.
     *
     * @return SaleWorkflowState
     */
    public function findProcessedState();

}