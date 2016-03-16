<?php namespace Modules\Football\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Event\Entities\Event;
use Modules\Football\Entities\FootballGame;
use LaravelDoctrine\Fluent\Fluent;

class FootballGameMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return FootballGame::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('football_games');
    }

}