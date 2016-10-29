<?php namespace Modules\Sales\Entities;

use Carbon\Carbon;
use Modules\Catalog\Entities\AcceptedLineTrait;
use Modules\Catalog\Entities\Side as SideEntity;

class QuoteAcceptedLine extends QuoteItem {

    use AcceptedLineTrait;

    public function calculateCost() {

        $base = $this->amount;
        $advertisedLine = $this->getAdvertisedLine();
        $side = $advertisedLine->getSide();
        $odds = $advertisedLine->getOdds() * -1;

        // @todo: Calculation below for odds is wrong.
        /*if($side->getMachineName() === SideEntity::SIDE_SEEKER) {

            if($odds == 0) {
                $toWin = 0;
            } else if($odds < 0) {
                $toWin = bcdiv($base,bcmul($odds * -1,'.01',4),4);
            } else {
                $toWin = bcmul($base,bcmul($odds,'.01',4),4);
            }

            $base = bcadd($base,$toWin,4);

        }*/

        $cost = bcmul($base,$this->quantity,4);
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