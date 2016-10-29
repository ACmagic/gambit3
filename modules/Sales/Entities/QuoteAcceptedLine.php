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
        $odds = $advertisedLine->getOdds();

        if($side->getMachineName() === SideEntity::SIDE_SEEKER && $odds != 0) {

            if($odds < 0) {
                $base = bcadd($base,bcdiv($base,bcmul($odds * -1,'.01',4),4),4);
            } else {
                $base = bcmul($base,bcmul($odds,'.01',4),4);
            }

        }

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