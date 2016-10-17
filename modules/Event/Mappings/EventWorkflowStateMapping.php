<?php namespace Modules\Event\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Event\Entities\EventWorkflowState;
use Modules\Event\Entities\EventWorkflow;
use LaravelDoctrine\Fluent\Fluent;
use LaravelDoctrine\Fluent\Relations\ManyToOne;

class EventWorkflowStateMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return EventWorkflowState::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('event_workflow_states');

        // Make workflow associated with event workflow.
        $builder->override('workflow',function(ManyToOne $associationBuilder) {
            $relation = new ManyToOne(
                $associationBuilder->getBuilder(),
                $associationBuilder->getNamingStrategy(),
                'workflow',
                EventWorkflow::class
            );
            return $relation;
        });
    }

}