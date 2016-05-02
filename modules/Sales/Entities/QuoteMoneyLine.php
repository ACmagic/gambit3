<?php namespace Modules\Sales\Entities;

use Modules\Vegas\Entities\MoneyLineTrait;

use Carbon\Carbon;

class QuoteMoneyLine extends QuotePrediction {

    use MoneyLineTrait;

    public function toSalePrediction() {

        $prediction = new SaleMoneyLine();
        $prediction->setCreatedAt(Carbon::now());
        $prediction->setUpdatedAt(Carbon::now());
        $prediction->setGame($this->game);
        $prediction->setPick($this->pick);

        return $prediction;

    }

}