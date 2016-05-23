<?php namespace Modules\Sales\Entities;

use Modules\Workflow\Entities\Transition;

class SaleWorkflowTransition extends Transition {

    protected $sale;

    public function getSale() {
        return $this->sale;
    }

    public function setSale(Sale $sale) {
        $this->sale = $sale;
    }

}