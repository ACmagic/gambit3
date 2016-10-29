<?php namespace Modules\Sales\Entities;

use Modules\Catalog\Entities\AcceptedLineTrait;
use Modules\Catalog\Entities\AcceptedLine;
use Modules\Catalog\Entities\Side as SideEntity;

class SaleAcceptedLine extends SaleItem {

    use AcceptedLineTrait;

    protected $acceptedLine;

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