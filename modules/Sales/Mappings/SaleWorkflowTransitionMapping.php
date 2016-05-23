<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Sales\Entities\SaleWorkflowTransition;
use Modules\Sales\Entities\SaleWorkflowState;
use Modules\Sales\Entities\Sale;
use LaravelDoctrine\Fluent\Fluent;
use LaravelDoctrine\Fluent\Relations\ManyToOne;

class SaleWorkflowTransitionMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return SaleWorkflowTransition::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('sale_workflow_transitions');

        $builder->belongsTo(Sale::class,'sale');

        // Restrict state associations to sale workflow states.
        $builder->override('beforeState',function(ManyToOne $associationBuilder) {
            $relation = new ManyToOne(
                $associationBuilder->getBuilder(),
                $associationBuilder->getNamingStrategy(),
                'beforeState',
                SaleWorkflowState::class
            );
            return $relation;
        });

        $builder->override('afterState',function(ManyToOne $associationBuilder) {
            $relation = new ManyToOne(
                $associationBuilder->getBuilder(),
                $associationBuilder->getNamingStrategy(),
                'afterState',
                SaleWorkflowState::class
            );
            return $relation;
        });

    }

}