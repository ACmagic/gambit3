<?php namespace Modules\Vegas\Entities;

use Modules\Sports\Entities\Team;
use Modules\Sports\Entities\Game;

trait MoneyLineTrait {

    protected $pick;
    protected $game;

    public function setPick(Team $pick) {
        $this->pick = $pick;
    }

    public function getPick() :Team {
        return $this->pick;
    }

    public function setGame(Game $game) {
        $this->game = $game;
    }

    public function getGame() : Game {
        return $this->game;
    }

    public function jsonSerialize() {

        $json = [];

        $json['type'] = get_class($this);
        $json['game_id'] = $this->getGame()->getId();
        $json['pick_id'] = $this->getPick()->getId();

        return $json;

    }

}