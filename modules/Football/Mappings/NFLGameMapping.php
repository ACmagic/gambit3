<?php namespace Modules\Football\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Football\Entities\NFLGame;
use Modules\Football\Entities\NFLTeam;
use LaravelDoctrine\Fluent\Fluent;
use LaravelDoctrine\Fluent\Relations\ManyToOne;

class NFLGameMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return NFLGame::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {

        $builder->table('nfl_football_games');

        // Make team association specific to nfl teams.
        $builder->override('homeTeam',function(ManyToOne $associationBuilder) {
            $relation = new ManyToOne(
                $associationBuilder->getBuilder(),
                $associationBuilder->getNamingStrategy(),
                'homeTeam',
                NFLTeam::class
            );
            return $relation;
        });

        // Make team association specific to nfl teams.
        $builder->override('awayTeam',function(ManyToOne $associationBuilder) {
            $relation = new ManyToOne(
                $associationBuilder->getBuilder(),
                $associationBuilder->getNamingStrategy(),
                'awayTeam',
                NFLTeam::class
            );
            return $relation;
        });

    }

}