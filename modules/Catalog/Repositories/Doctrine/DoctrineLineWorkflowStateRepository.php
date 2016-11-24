<?php namespace Modules\Catalog\Repositories\Doctrine;

use Modules\Catalog\Repositories\LineWorkflowStateRepository;
use Modules\Workflow\Repositories\Doctrine\DoctrineStateRepository;
use Modules\Catalog\Entities\LineWorkflowState;

class DoctrineLineWorkflowStateRepository extends DoctrineStateRepository implements LineWorkflowStateRepository {

    /**
     * Get open state.
     *
     * @return LineWorkflowState
     */
    public function findOpenState() : LineWorkflowState {
        return $this->genericRepository->findOneByMachineName(LineWorkflowState::STATE_OPEN);
    }

    /**
     * Get closed state.
     *
     * @return LineWorkflowState
     */
    public function findClosedState() : LineWorkflowState {
        return $this->genericRepository->findOneByMachineName(LineWorkflowState::STATE_CLOSED);
    }

    /**
     * Get paying back state.
     *
     * @return LineWorkflowState
     */
    public function findPayingBackState() : LineWorkflowState {
        return $this->genericRepository->findOneByMachineName(LineWorkflowState::STATE_PAYINGBACK);
    }

    /**
     * Get paid back state.
     *
     * @return LineWorkflowState
     */
    public function findPaidBackState() : LineWorkflowState {
        return $this->genericRepository->findOneByMachineName(LineWorkflowState::STATE_PAIDBACK);
    }

    /**
     * Get complete state.
     *
     * @return LineWorkflowState
     */
    public function findCompleteState() : LineWorkflowState {
        return $this->genericRepository->findOneByMachineName(LineWorkflowState::STATE_COMPLETE);
    }

    /**
     * Get paying out state.
     *
     * @return LineWorkflowState
     */
    public function findPayingOutState() : LineWorkflowState {
        return $this->genericRepository->findOneByMachineName(LineWorkflowState::STATE_PAYINGOUT);
    }

    /**
     * Get done state.
     *
     * @return LineWorkflowState
     */
    public function findDoneState() : LineWorkflowState {
        return $this->genericRepository->findOneByMachineName(LineWorkflowState::STATE_DONE);
    }

}