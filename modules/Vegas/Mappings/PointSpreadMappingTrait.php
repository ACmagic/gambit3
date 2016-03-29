<?php namespace Modules\Vegas\Mappings;

use LaravelDoctrine\Fluent\Fluent;
use Modules\Sports\Entities\Team;
use Modules\Sports\Entities\Game;

trait PointSpreadMappingTrait {

    protected function mapPointSpread(Fluent $builder) {

        $builder->belongsTo(Team::class,'pick');
        $builder->belongsTo(Game::class,'game');
        $builder->float('spread')->precision(5)->scale(1)->default(0.5);

    }

}