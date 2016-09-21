<?php namespace Modules\Sales\Entities;

use Modules\Catalog\Entities\AcceptedLineTrait;

class SaleAcceptedLine extends SaleItem {

    use AcceptedLineTrait;

    public function calculateCost() {

        // @todo: Take into considerations side and odds.
        $cost = bcmul($this->amount,$this->quantity,4);

        return $cost;

    }

    public function isPayableViaCredits() {
        return true;
    }

}