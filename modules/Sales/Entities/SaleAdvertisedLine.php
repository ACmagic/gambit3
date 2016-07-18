<?php namespace Modules\Sales\Entities;

use Carbon\Carbon;
use Modules\Catalog\Entities\AdvertisedLineTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Modules\Catalog\Entities\Line as LineEntity;

class SaleAdvertisedLine extends SaleItem {

    use AdvertisedLineTrait;

    protected $predictionsCache;
    protected $predictions;

    public function __construct() {
        $this->predictions = new ArrayCollection();
    }

    public function getPredictions() : ArrayCollection {
        return $this->predictions;
    }

    public function addPrediction(SalePrediction $prediction) {
        $this->predictions[] = $prediction;
    }

    public function setPredictionsCache(array $predictionsCache) {
        $this->predictionsCache = $predictionsCache;
    }

    public function getPredictionsCache() : array {
        return $this->predictionsCache;
    }

    public function calculateCost() : string {

        $base = $this->amount;

        if($this->amountMax) {
            $base = $this->amountMax;
        }

        // @todo: Add odds calculation
        return bcmul($base,$this->inventory,4);

    }

    public function isPayableViaCredits() :bool {
        return true;
    }

    /**
     * Convert this to a line.
     *
     * @return LineEntity
     */
    public function toLine() : LineEntity {

        $side = $this->getSide();
        $store = $this->getSale()->getStore();

        $line = new LineEntity();
        $line->setStore($store);
        $line->setOdds($this->getOdds());
        $line->setSide($side);
        $line->setCreatedAt(Carbon::now());
        $line->setUpdatedAt(Carbon::now());

        foreach($this->predictions as $prediction) {

            $newPrediction = $prediction->toStandardPrediction();
            $newPrediction->setLine($line);
            $line->addPrediction($newPrediction);

        }

        return $line;

    }

    public function doRebuildPredictionsCache() {

        $this->predictionsCache = [];

        foreach($this->getPredictions() as $prediction) {
            $this->predictionsCache[] = $prediction;
        }

    }

}