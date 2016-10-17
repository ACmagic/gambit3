<?php namespace Modules\Event\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Core\Entities\User;
use Modules\Event\Entities\Event;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Event\Entities\Category;
use Modules\Sports\Entities\Game as SportsGame;
use Modules\Football\Entities\NFLGame as NFLFootballGame;
use Modules\Event\Entities\EventWorkflowState;

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
        $builder->belongsTo(EventWorkflowState::class,'state');
        $builder->timestamp('startsAt');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        $builder->manyToMany(Category::class,'categories')->joinTable('event_categories')->fetchExtraLazy();

        $builder->joinedTableInheritance()
            ->column('type')
            ->map(Event::class,Event::class)
            ->map(SportsGame::class,SportsGame::class)
            ->map(NFLFootballGame::class,NFLFootballGame::class);
    }

}