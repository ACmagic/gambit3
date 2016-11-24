<?php namespace Modules\Catalog\Repositories;

use Modules\Workflow\Repositories\StateRepository;
use Modules\Catalog\Entities\LineWorkflowState;

interface LineWorkflowStateRepository extends StateRepository {

    /**
     * Get open state.
     *
     * @return LineWorkflowState
     */
    public function findOpenState() : LineWorkflowState;

    /**
     * Get closed state.
     *
     * @return LineWorkflowState
     */
    public function findClosedState() : LineWorkflowState;

    /**
     * Get paying back state.
     *
     * @return LineWorkflowState
     */
    public function findPayingBackState() : LineWorkflowState;

    /**
     * Get paid back state.
     *
     * @return LineWorkflowState
     */
    public function findPaidBackState() : LineWorkflowState;

    /**
     * Get the complete state.
     */
    public function findCompleteState(): LineWorkflowState;

    /**
     * Get the paying out state.
     */
    public function findPayingOutState(): LineWorkflowState;

    /**
     * Get the done state.
     */
    public function findDoneState(): LineWorkflowState;

}