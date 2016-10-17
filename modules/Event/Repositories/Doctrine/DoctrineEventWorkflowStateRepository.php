<?php namespace Modules\Event\Repositories\Doctrine;

use Modules\Event\Repositories\EventWorkflowStateRepository;
use Modules\Workflow\Repositories\Doctrine\DoctrineStateRepository;
use Modules\Event\Entities\EventWorkflowState;

class DoctrineEventWorkflowStateRepository extends DoctrineStateRepository implements EventWorkflowStateRepository {

    /**
     * Get pending state.
     *
     * @return EventWorkflowState
     */
    public function findPendingState() {
        return $this->genericRepository->findOneByMachineName(EventWorkflowState::STATE_PENDING);
    }

    /**
     * Get open state.
     *
     * @return EventWorkflowState
     */
    public function findOpenState() {
        return $this->genericRepository->findOneByMachineName(EventWorkflowState::STATE_OPEN);
    }

    /**
     * Get inprogress state.
     *
     * @return EventWorkflowState
     */
    public function findInProgressState() {
        return $this->genericRepository->findOneByMachineName(EventWorkflowState::STATE_INPROGRESS);
    }

    /**
     * Get complete state.
     *
     * @return EventWorkflowState
     */
    public function findCompleteState() {
        return $this->genericRepository->findOneByMachineName(EventWorkflowState::STATE_COMPLETE);
    }

    /**
     * Get done state.
     *
     * @return EventWorkflowState
     */
    public function findDoneState() {
        return $this->genericRepository->findOneByMachineName(EventWorkflowState::STATE_DONE);
    }

}