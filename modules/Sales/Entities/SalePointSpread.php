<?php namespace Modules\Sales\Entities;

use Carbon\Carbon;
use Modules\Vegas\Entities\PointSpreadTrait;
use Modules\Prediction\Entities\Prediction;
use Modules\Vegas\Entities\PointSpread;

class SalePointSpread extends SalePrediction {

    use PointSpreadTrait;

    public function toStandardPrediction() : Prediction {

        $pick = $this->getPick();
        $game = $this->getGame();

        $prediction = new PointSpread();
        $prediction->setCreatedAt(Carbon::now());
        $prediction->setUpdatedAt(Carbon::now());
        $prediction->setPick($pick);
        $prediction->setGame($game);
        $prediction->setSpread($this->getSpread());

        return $prediction;

    }

}