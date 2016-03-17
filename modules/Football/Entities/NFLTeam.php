<?php namespace Modules\Football\Entities;

use Modules\Sports\Entities\Team;

class NFLTeam extends Team {

    protected $machineName;

    public function getMachineName() {
        return $this->machineName;
    }

}