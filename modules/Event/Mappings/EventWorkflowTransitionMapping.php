<?php namespace Modules\Event\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Event\Entities\EventWorkflowTransition;
use Modules\Event\Entities\EventWorkflowState;
use Modules\Event\Entities\Event as EventEntity;
use LaravelDoctrine\Fluent\Fluent;
use LaravelDoctrine\Fluent\Relations\ManyToOne;

class EventWorkflowTransitionMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return EventWorkflowTransition::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('event_workflow_transitions');

        $builder->belongsTo(EventEntity::class,'event');

        // Restrict state associations to sale workflow states.
        $builder->override('beforeState',function(ManyToOne $associationBuilder) {
            $relation = new ManyToOne(
                $associationBuilder->getBuilder(),
                $associationBuilder->getNamingStrategy(),
                'beforeState',
                EventWorkflowState::class
            );
            return $relation;
        });

        $builder->override('afterState',function(ManyToOne $associationBuilder) {
            $relation = new ManyToOne(
                $associationBuilder->getBuilder(),
                $associationBuilder->getNamingStrategy(),
                'afterState',
                EventWorkflowState::class
            );
            return $relation;
        });

    }

}