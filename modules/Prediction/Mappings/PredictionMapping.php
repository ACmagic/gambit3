<?php namespace Modules\Prediction\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Prediction\Entities\Prediction;
use Modules\Catalog\Entities\Line;
use LaravelDoctrine\Fluent\Fluent;

class PredictionMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Prediction::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('predictions');
        $builder->increments('id');
        $builder->belongsTo(Line::class,'line');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        /*$builder->joinedTableInheritance()
            ->column('type')
            ->map(Competitor::class,Competitor::class)
            ->map(SportsTeam::class,SportsTeam::class)
            ->map(SportsPlayer::class,SportsPlayer::class)
            ->map(NFLFootballTeam::class,NFLFootballTeam::class);*/
    }

}