<?php namespace Modules\Catalog\Repositories;

use Modules\Workflow\Repositories\StateRepository;
use Modules\Catalog\Entities\LineWorkflowState;

interface LineWorkflowStateRepository extends StateRepository {

    /**
     * Get paid state.
     *
     * @return LineWorkflowState
     */
    public function findOpenState() : LineWorkflowState;

    /**
     * Get submitted state.
     *
     * @return LineWorkflowState
     */
    public function findClosedState() : LineWorkflowState;

}