<?php namespace Modules\Sales\Entities;

use Modules\Vegas\Entities\PointSpreadTrait;
use Carbon\Carbon;

class QuotePointSpread extends QuotePrediction {

    use PointSpreadTrait;

    public function toSalePrediction() {

        $prediction = new SalePointSpread();
        $prediction->setCreatedAt(Carbon::now());
        $prediction->setUpdatedAt(Carbon::now());
        $prediction->setGame($this->game);
        $prediction->setPick($this->pick);
        $prediction->setSpread($this->spread);

        return $prediction;

    }

}