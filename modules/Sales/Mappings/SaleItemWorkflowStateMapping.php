<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Sales\Entities\SaleItemWorkflowState;
use Modules\Sales\Entities\SaleItemWorkflow;
use LaravelDoctrine\Fluent\Fluent;
use LaravelDoctrine\Fluent\Relations\ManyToOne;

class SaleItemWorkflowStateMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return SaleItemWorkflowState::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('sale_item_workflow_states');

        // Make workflow associated with sale workflow.
        $builder->override('workflow',function(ManyToOne $associationBuilder) {
            $relation = new ManyToOne(
                $associationBuilder->getBuilder(),
                $associationBuilder->getNamingStrategy(),
                'workflow',
                SaleItemWorkflow::class
            );
            return $relation;
        });
    }

}