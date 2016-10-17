<?php namespace Modules\Event\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Event\Entities\EventWorkflow;
use LaravelDoctrine\Fluent\Fluent;

class EventWorkflowMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return EventWorkflow::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('event_workflows');
    }

}