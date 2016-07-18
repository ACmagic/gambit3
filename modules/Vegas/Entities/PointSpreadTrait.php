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

    public function getPick() : Team {
        return $this->pick;
    }

    public function setGame(Game $game) {
        $this->game = $game;
    }

    public function getGame() : Game {
        return $this->game;
    }

    public function setSpread($spread) {
        $this->spread = $spread;
    }

    public function getSpread() {
        return $this->spread;
    }

    public function jsonSerialize() {

        $json = [];

        $json['type'] = get_class($this);
        $json['game_id'] = $this->getGame()->getId();
        $json['pick_id'] = $this->getPick()->getId();
        $json['spread'] = $this->getSpread();

        return $json;

    }

}