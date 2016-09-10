<?php namespace Modules\Vegas\Entities;

use Modules\Prediction\Entities\InversePrediction;
use Modules\Vegas\Contracts\Entities\PointSpread as PointSpreadContract;
use Modules\Sports\Entities\Team;

class InversePointSpread extends InversePrediction implements PointSpreadContract {

    use PointSpreadTrait;

    public function getPick(): Team {

        if($this->game->getHomeTeam()->getId() === $this->pick->getId()) {
            $pick = $this->game->getAwayTeam();
        } else {
            $pick = $this->game->getHomeTeam();
        }

        return $pick;

    }

    public function getSpread() {
        return $this->spread * -1;
    }

}