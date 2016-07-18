<?php namespace Modules\Sales\Entities;

use Carbon\Carbon;
use Modules\Vegas\Entities\MoneyLineTrait;
use Modules\Prediction\Entities\Prediction;
use Modules\Vegas\Entities\MoneyLine;

class SaleMoneyLine extends SalePrediction {

    use MoneyLineTrait;

    public function toStandardPrediction() : Prediction {

        $pick = $this->getPick();
        $game = $this->getGame();

        $prediction = new MoneyLine();
        $prediction->setCreatedAt(Carbon::now());
        $prediction->setUpdatedAt(Carbon::now());
        $prediction->setPick($pick);
        $prediction->setGame($game);

        return $prediction;

    }

}