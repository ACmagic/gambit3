<?php namespace Modules\Event\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Core\Entities\User;
use Modules\Event\Entities\Event;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sports\Entities\Game as SportsGame;
use Modules\Football\Entities\NFLGame as NFLFootballGame;

class EventMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Event::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {

        $builder->table('events');
        $builder->increments('id');
        $builder->string('displayTitle')->length(128);
        $builder->belongsTo(User::class,'creator');
        $builder->timestamp('startsAt');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        $builder->joinedTableInheritance()
            ->column('type')
            ->map(Event::class,Event::class)
            ->map(SportsGame::class,SportsGame::class)
            ->map(NFLFootballGame::class,NFLFootballGame::class);
    }

}