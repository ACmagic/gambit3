<?php namespace Modules\Vegas\Entities;

use Modules\Prediction\Entities\Prediction;
use Modules\Sports\Entities\Team;

class PointSpread extends Prediction {

    protected $pick;
    protected $spread;

    public function setPick(Team $pick) {
        $this->pick = $pick;
    }

    public function getPick() {
        return $this->pick;
    }

}