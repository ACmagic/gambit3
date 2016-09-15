<?php namespace Modules\Workflow\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Workflow\Entities\Transition;
use Modules\Workflow\Entities\State;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\SaleWorkflowTransition;
use Modules\Sales\Entities\SaleItemWorkflowTransition;
use Modules\Catalog\Entities\LineWorkflowTransition;

class TransitionMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Transition::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('workflow_transitions');
        $builder->bigIncrements('id');
        $builder->belongsTo(State::class,'beforeState');
        $builder->belongsTo(State::class,'afterState');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        $builder->joinedTableInheritance()
            ->column('type')
            ->map(Transition::class,Transition::class)
            ->map(SaleWorkflowTransition::class,SaleWorkflowTransition::class)
            ->map(SaleItemWorkflowTransition::class,SaleItemWorkflowTransition::class)
            ->map(LineWorkflowTransition::class,LineWorkflowTransition::class);
    }

}