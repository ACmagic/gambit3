<?php namespace Modules\Vegas\Entities;

use Modules\Prediction\Entities\Prediction;
use Modules\Sports\Entities\Team;

class MoneyLine extends Prediction {

    protected $pick;

    public function setPick(Team $pick) {
        $this->pick = $pick;
    }

    public function getPick() {
        return $this->pick;
    }

}