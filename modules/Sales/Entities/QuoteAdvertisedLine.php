<?php namespace Modules\Sales\Entities;

use Modules\Catalog\Entities\AdvertisedLineTrait;
use Doctrine\Common\Collections\ArrayCollection;

class QuoteAdvertisedLine extends QuoteItem {

    use AdvertisedLineTrait;

    protected $predictions;

    public function __construct() {
        $this->predictions = new ArrayCollection();
    }

    public function addPrediction(QuotePrediction $prediction) {
        $this->predictions[] = $prediction;
    }

}