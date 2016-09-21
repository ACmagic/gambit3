<?php namespace Modules\Sales\Entities;

use Carbon\Carbon;
use Modules\Catalog\Entities\AcceptedLineTrait;

class QuoteAcceptedLine extends QuoteItem {

    use AcceptedLineTrait;

    public function calculateCost() {

        // @todo: Take into considerations side and odds.
        $cost = bcmul($this->amount,$this->quantity,4);

        return $cost;

    }

    public function toSaleItem() {

        $item = new SaleAcceptedLine();
        $item->setCreatedAt(Carbon::now());
        $item->setUpdatedAt(Carbon::now());
        $item->setAmount($this->amount);
        $item->setQuantity($this->quantity);
        $item->setAdvertisedLine($this->advertisedLine);

        return $item;

    }

    public function isPayableViaCredits() {
        return true;
    }

}