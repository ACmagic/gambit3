<?php namespace Modules\Sales\Entities;

use Modules\Catalog\Entities\AcceptedLineTrait;

class QuoteAcceptedLine extends QuoteItem {

    use AcceptedLineTrait;

    public function calculateCost() {

        // @todo: I think this also needs to take into consideration the side and odds of the associated advertised line.
        return $this->amount;

    }

}