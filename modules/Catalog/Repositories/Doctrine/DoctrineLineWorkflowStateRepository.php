<?php namespace Modules\Catalog\Repositories\Doctrine;

use Modules\Catalog\Repositories\LineWorkflowStateRepository;
use Modules\Workflow\Repositories\Doctrine\DoctrineStateRepository;
use Modules\Catalog\Entities\LineWorkflowState;

class DoctrineLineWorkflowStateRepository extends DoctrineStateRepository implements LineWorkflowStateRepository {

    /**
     * Get paid state.
     *
     * @return LineWorkflowState
     */
    public function findOpenState() : LineWorkflowState {
        return $this->genericRepository->findOneByMachineName(LineWorkflowState::STATE_OPEN);
    }

    /**
     * Get submitted state.
     *
     * @return LineWorkflowState
     */
    public function findClosedState() : LineWorkflowState {
        return $this->genericRepository->findOneByMachineName(SaleWorkflowState::STATE_CLOSED);
    }

}