<?php namespace Modules\Sales\Entities;

use Modules\Catalog\Entities\AdvertisedLineTrait;
use Doctrine\Common\Collections\ArrayCollection;

class SaleAdvertisedLine extends SaleItem {

    use AdvertisedLineTrait;

    protected $predictions;

    public function __construct() {
        $this->predictions = new ArrayCollection();
    }

    public function addPrediction(SalePrediction $prediction) {
        $this->predictions[] = $prediction;
    }

}