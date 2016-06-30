<?php namespace Modules\Sales\Entities;

use Modules\Catalog\Entities\AdvertisedLineTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Modules\Catalog\Entities\Line as LineEntity;

class SaleAdvertisedLine extends SaleItem {

    use AdvertisedLineTrait;

    protected $predictions;

    public function __construct() {
        $this->predictions = new ArrayCollection();
    }

    public function addPrediction(SalePrediction $prediction) {
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

    public function isPayableViaCredits() {
        return true;
    }

    /**
     * Convert this to a line.
     *
     * @return LineEntity
     */
    public function toLine() {

        $line = new LineEntity();

    }

}