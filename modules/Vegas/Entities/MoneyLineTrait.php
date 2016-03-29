<?php namespace Modules\Vegas\Entities;

use Modules\Sports\Entities\Team;
use Modules\Sports\Entities\Game;

trait MoneyLineTrait {

    protected $pick;
    protected $game;

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

}