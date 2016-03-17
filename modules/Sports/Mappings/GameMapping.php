<?php namespace Modules\Sports\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Sports\Entities\Game;
use Modules\Sports\Entities\Team;
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
        $builder->belongsTo(Team::class,'homeTeam');
        $builder->belongsTo(Team::class,'awayTeam');
    }

}