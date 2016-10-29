<?php namespace Modules\Sales\Entities;

use Carbon\Carbon;
use Modules\Catalog\Entities\AdvertisedLineTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Modules\Catalog\Entities\Line as LineEntity;
use Modules\Catalog\Entities\AdvertisedLine;
use Doctrine\Common\Collections\Collection;
use Modules\Catalog\Entities\Side as SideEntity;

class SaleAdvertisedLine extends SaleItem {

    use AdvertisedLineTrait;

    protected $predictionsCache;
    protected $predictions;
    protected $advertisedLine;

    public function __construct() {
        parent::__construct();
        $this->predictions = new ArrayCollection();
    }

    public function getPredictions() : Collection {
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

    public function setAdvertisedLine(AdvertisedLine $advertisedLine) {
        $this->advertisedLine = $advertisedLine;
    }

    public function getAdvertisedLine() : AdvertisedLine {
        return $this->advertisedLine;
    }

    public function calculateCost() : string {

        $base = $this->amount;

        if($this->amountMax) {
            $base = $this->amountMax;
        }

        // @todo: Calculation below for odds is wrong.
        /*if($this->getSide()->getMachineName() === SideEntity::SIDE_HOUSE) {

            if($this->odds == 0) {
                $toWin = 0;
            } else if($this->odds < 0) {
                $toWin = bcdiv($base,bcmul($this->odds * -1,'.01',4),4);
            } else {
                $toWin = bcmul($base,bcmul($this->odds,'.01',4),4);
            }

            $base = bcadd($base,$toWin,4);

        }*/

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
        //$line->setInverseOdds($this->getInverseOdds());
        $line->setSide($side);
        $line->setCreatedAt(Carbon::now());
        $line->setUpdatedAt(Carbon::now());

        // 0 out cached aggregated values.
        $line->setRollingInventory(0);
        $line->setRollingAmount(0);
        $line->setRollingAmountMax(0);
        $line->setRealTimeInventory(0);
        $line->setRealTimeAmount(0);
        $line->setRealTimeAmountMax(0);

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