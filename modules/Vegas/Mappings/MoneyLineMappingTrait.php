<?php namespace Modules\Vegas\Mappings;

use LaravelDoctrine\Fluent\Fluent;
use Modules\Sports\Entities\Team;
use Modules\Sports\Entities\Game;

trait MoneyLineMappingTrait {

    protected function mapMoneyLine(Fluent $builder) {

        $builder->belongsTo(Team::class,'pick');
        $builder->belongsTo(Game::class,'game');

    }

}