<?php namespace Modules\Sales\Entities;

use Modules\Catalog\Entities\AdvertisedLineTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Modules\Catalog\Entities\Side as SideEntity;

use Carbon\Carbon;

class QuoteAdvertisedLine extends QuoteItem {

    use AdvertisedLineTrait;

    protected $predictions;

    public function __construct() {
        $this->predictions = new ArrayCollection();
    }

    public function getPredictions() {
        return $this->predictions;
    }

    public function addPrediction(QuotePrediction $prediction) {
        $this->predictions[] = $prediction;
    }

    public function calculateCost() {

        $base = $this->amount;

        if($this->amountMax) {
            $base = $this->amountMax;
        }

        if($this->getSide()->getMachineName() === SideEntity::SIDE_HOUSE) {

            if($this->odds == 0) {
                $toWin = 0;
            } else if($this->odds < 0) {
                $toWin = bcdiv($base,bcmul($this->odds * -1,'.01',4),4);
            } else {
                $toWin = bcmul($base,bcmul($this->odds,'.01',4),4);
            }

            $base = bcadd($base,$toWin,4);

        }

        return bcmul($base,$this->inventory,4);


    }

    public function toSaleItem() {

        // @todo
        $item = new SaleAdvertisedLine();
        $item->setCreatedAt(Carbon::now());
        $item->setUpdatedAt(Carbon::now());
        $item->setSide($this->side);
        $item->setOdds($this->odds);
        $item->setAmount($this->amount);
        $item->setAmountMax($this->amountMax);
        $item->setInventory($this->inventory);

        foreach($this->predictions as $prediction) {

            $salePrediction = $prediction->toSalePrediction();
            $salePrediction->setAdvertisedLine($item);
            $item->addPrediction($salePrediction);

        }

        return $item;

    }

    public function isPayableViaCredits() {
        return true;
    }

}