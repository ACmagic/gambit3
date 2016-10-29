<?php namespace Modules\Sports\Entities;

use Modules\Event\Entities\Event as EventEntity;

class Game extends EventEntity {

    protected $homeTeam;
    protected $awayTeam;

    protected $homeTeamScore;
    protected $awayTeamScore;

    protected $season;

    public function setHomeTeam(Team $team) {
        $this->homeTeam = $team;
    }

    public function setAwayTeam(Team $team) {
        $this->awayTeam = $team;
    }

    public function setSeason(Season $season) {
        $this->season = $season;
    }

    public function getAwayTeam() {
        return $this->awayTeam;
    }

    public function getHomeTeam() {
        return $this->homeTeam;
    }

    public function setHomeTeamScore(float $homeTeamScore) {
        $this->homeTeamScore = $homeTeamScore;
    }

    public function getHomeTeamScore() {
        return $this->homeTeamScore;
    }

    public function setAwayTeamScore(float $awayTeamScore) {
        $this->awayTeamScore = $awayTeamScore;
    }

    public function getAwayTeamScore() {
        return $this->awayTeamScore;
    }

    public function getSeason() {
        return $this->season;
    }

}