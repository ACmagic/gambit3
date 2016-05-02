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

    public function addPrediction(QuotePrediction $prediction) {
        $this->predictions[] = $prediction;
    }

    public function calculateCost() {

        // @todo: Calculate the cost based on amount/amount_max and inventory.

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
            $item->addPrediction($item);

        }

        return $item;

    }

}