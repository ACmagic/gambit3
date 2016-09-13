<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Sales\Entities\SaleItemWorkflowTransition;
use Modules\Sales\Entities\SaleItemWorkflowState;
use Modules\Sales\Entities\SaleItem;
use LaravelDoctrine\Fluent\Fluent;
use LaravelDoctrine\Fluent\Relations\ManyToOne;

class SaleItemWorkflowTransitionMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return SaleItemWorkflowTransition::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('sale_item_workflow_transitions');

        $builder->belongsTo(SaleItem::class,'saleItem');

        // Restrict state associations to sale workflow states.
        $builder->override('beforeState',function(ManyToOne $associationBuilder) {
            $relation = new ManyToOne(
                $associationBuilder->getBuilder(),
                $associationBuilder->getNamingStrategy(),
                'beforeState',
                SaleItemWorkflowState::class
            );
            return $relation;
        });

        $builder->override('afterState',function(ManyToOne $associationBuilder) {
            $relation = new ManyToOne(
                $associationBuilder->getBuilder(),
                $associationBuilder->getNamingStrategy(),
                'afterState',
                SaleItemWorkflowState::class
            );
            return $relation;
        });

    }

}