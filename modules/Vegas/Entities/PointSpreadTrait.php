<?php namespace Modules\Vegas\Entities;

use Modules\Sports\Entities\Team;
use Modules\Sports\Entities\Game;

trait PointSpreadTrait {

    protected $pick;
    protected $game;
    protected $spread;

    public function setPick(Team $pick) {
        $this->pick = $pick;
    }

    public function getPick() {
        return $this->pick;
    }

    public function setGame(Game $game) {
        $this->game = $game;
    }

    public function getGame() {
        return $this->game;
    }

    public function setSpread($spread) {
        $this->spread = $spread;
    }

    public function getSpread() {
        return $this->spread;
    }

}