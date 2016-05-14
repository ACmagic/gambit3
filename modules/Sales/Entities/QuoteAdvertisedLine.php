<?php namespace Modules\Sales\Entities;

use Modules\Catalog\Entities\AdvertisedLineTrait;
use Doctrine\Common\Collections\ArrayCollection;

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

        // @todo: Add odds calculation
        return bcmul($base,$this->inventory,4);


    }

    public function toSaleItem() {

        // @todo
        $item = new SaleAdvertisedLine();
        $item->setCreatedAt(Carbon::now());
        $item->setUpdatedAt(Carbon::now());
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