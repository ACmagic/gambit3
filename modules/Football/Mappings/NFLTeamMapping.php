<?php namespace Modules\Football\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Football\Entities\NFLTeam;
use LaravelDoctrine\Fluent\Fluent;

class NFLTeamMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return NFLTeam::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('nfl_football_teams');
        $builder->string('machineName')->length(128)->unique();
    }

}