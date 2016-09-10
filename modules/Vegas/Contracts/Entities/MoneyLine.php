<?php namespace Modules\Vegas\Contracts\Entities;

use Modules\Prediction\Contracts\Entities\Prediction;
use Modules\Sports\Entities\Team;
use Modules\Sports\Entities\Game;

interface MoneyLine extends Prediction {
    public function setPick(Team $pick);
    public function getPick() :Team;
    public function setGame(Game $game);
    public function getGame() : Game;
}