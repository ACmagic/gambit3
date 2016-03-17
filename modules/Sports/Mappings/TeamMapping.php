<?php namespace Modules\Sports\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Sports\Entities\Team;
use LaravelDoctrine\Fluent\Fluent;

class TeamMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Team::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('sports_teams');
        $builder->string('name')->length(57);
    }

}