<?php namespace Modules\Sales\Entities;

use Modules\Workflow\Entities\Transition;

class SaleItemWorkflowTransition extends Transition {

    protected $saleItem;

    public function getSaleItem() : SaleItem {
        return $this->saleItem;
    }

    public function setSaleItem(SaleItem $saleItem) {
        $this->saleItem = $saleItem;
    }

}