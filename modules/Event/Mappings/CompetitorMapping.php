<?php namespace Modules\Event\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Core\Entities\User;
use Modules\Event\Entities\Competitor;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sports\Entities\Player as SportsPlayer;
use Modules\Sports\Entities\Team as SportsTeam;

class CompetitorMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Competitor::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {

        $builder->table('competitors');
        $builder->increments('id');
        $builder->belongsTo(User::class,'creator');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        $builder->joinedTableInheritance()
            ->column('type')
            ->map(SportsTeam::class,SportsTeam::class)
            ->map(SportsPlayer::class,SportsPlayer::class);
    }

}