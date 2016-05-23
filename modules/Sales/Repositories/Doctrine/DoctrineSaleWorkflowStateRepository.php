<?php namespace Modules\Sales\Repositories\Doctrine;

use Modules\Sales\Repositories\SaleWorkflowStateRepository;
use Modules\Workflow\Repositories\Doctrine\DoctrineStateRepository;
use Modules\Sales\Entities\SaleWorkflowState;

class DoctrineSaleWorkflowStateRepository extends DoctrineStateRepository implements SaleWorkflowStateRepository {

    /**
     * Get paid state.
     *
     * @return SaleWorkflowState
     */
    public function findPaidState() {
        return $this->genericRepository->findOneByMachineName(SaleWorkflowState::STATE_PAID);
    }

    /**
     * Get submitted state.
     *
     * @return SaleWorkflowState
     */
    public function findSubmittedState() {
        return $this->genericRepository->findOneByMachineName(SaleWorkflowState::STATE_SUBMITTED);
    }

    /**
     * Get processing state.
     *
     * @return SaleWorkflowState
     */
    public function findProcessingState() {
        return $this->genericRepository->findOneByMachineName(SaleWorkflowState::STATE_PROCESSING);
    }

    /**
     * Get processed state.
     *
     * @return SaleWorkflowState
     */
    public function findProcessedState() {
        return $this->genericRepository->findOneByMachineName(SaleWorkflowState::STATE_PROCESSED);
    }

}