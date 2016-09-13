<?php namespace Modules\Sales\Repositories\Doctrine;

use Modules\Sales\Repositories\SaleItemWorkflowStateRepository;
use Modules\Workflow\Repositories\Doctrine\DoctrineStateRepository;
use Modules\Sales\Entities\SaleItemWorkflowState;

class DoctrineSaleItemWorkflowStateRepository extends DoctrineStateRepository implements SaleItemWorkflowStateRepository {

    /**
     * Get paid state.
     *
     * @return SaleItemWorkflowState
     */
    public function findPaidState() : SaleItemWorkflowState {
        return $this->genericRepository->findOneByMachineName(SaleItemWorkflowState::STATE_PAID);
    }

}