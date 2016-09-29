<?php namespace Modules\Sales\Entities;

use Modules\Catalog\Entities\AcceptedLineTrait;
use Modules\Catalog\Entities\AcceptedLine;

class SaleAcceptedLine extends SaleItem {

    use AcceptedLineTrait;

    protected $acceptedLine;

    public function calculateCost() {

        // @todo: Take into considerations side and odds.
        $cost = bcmul($this->amount,$this->quantity,4);

        return $cost;

    }

    public function isPayableViaCredits() {
        return true;
    }

    public function getAcceptedLine() : AcceptedLine {
        return $this->acceptedLine;
    }

    public function setAcceptedLine(AcceptedLine $acceptedLine) {
        $this->acceptedLine = $acceptedLine;
    }

}