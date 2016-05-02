<?php namespace Modules\Sales\Entities;

use Modules\Catalog\Entities\AcceptedLineTrait;

class SaleAcceptedLine extends SaleItem {

    use AcceptedLineTrait;

    public function calculateCost() {

        // @todo: I think this also needs to take into consideration the side and odds of the associated advertised line.
        return $this->amount;

    }

}