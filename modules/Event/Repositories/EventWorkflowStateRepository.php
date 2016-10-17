<?php namespace Modules\Event\Repositories;

use Modules\Workflow\Repositories\StateRepository;
use Modules\Event\Entities\EventWorkflowState;

interface EventWorkflowStateRepository extends StateRepository {

    /**
     * Get pending state.
     *
     * @return EventWorkflowState
     */
    public function findPendingState();

    /**
     * Get open state.
     *
     * @return EventWorkflowState
     */
    public function findOpenState();

    /**
     * Get inprogress state.
     *
     * @return EventWorkflowState
     */
    public function findInProgressState();

    /**
     * Get complete state.
     *
     * @return EventWorkflowState
     */
    public function findCompleteState();

    /**
     * Get done state.
     *
     * @return EventWorkflowState
     */
    public function findDoneState();

}