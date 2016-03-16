<?php namespace Modules\Sports\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Sports\Entities\Game;
use LaravelDoctrine\Fluent\Fluent;

class GameMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Game::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('sports_games');
    }

}