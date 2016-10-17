<?php namespace Modules\Workflow\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Workflow\Entities\State as StateEntity;
use Modules\Workflow\Entities\Workflow;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\SaleWorkflowState;
use Modules\Sales\Entities\SaleItemWorkflowState;
use Modules\Catalog\Entities\LineWorkflowState;
use Modules\Event\Entities\EventWorkflowState;

class StateMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return StateEntity::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('workflow_states');
        $builder->bigIncrements('id');
        $builder->belongsTo(Workflow::class,'workflow');
        $builder->string('machineName')->length(128)->default('');
        $builder->string('humanName')->length(128)->default('');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        $builder->joinedTableInheritance()
            ->column('type')
            ->map(StateEntity::class,StateEntity::class)
            ->map(SaleWorkflowState::class,SaleWorkflowState::class)
            ->map(SaleItemWorkflowState::class,SaleItemWorkflowState::class)
            ->map(LineWorkflowState::class,LineWorkflowState::class)
            ->map(EventWorkflowState::class,EventWorkflowState::class);
    }

}