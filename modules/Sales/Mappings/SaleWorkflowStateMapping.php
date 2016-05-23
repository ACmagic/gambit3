<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Sales\Entities\SaleWorkflowState;
use Modules\Sales\Entities\SaleWorkflow;
use LaravelDoctrine\Fluent\Fluent;
use LaravelDoctrine\Fluent\Relations\ManyToOne;

class SaleWorkflowStateMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return SaleWorkflowState::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('sale_workflow_states');

        // Make workflow associated with sale workflow.
        $builder->override('workflow',function(ManyToOne $associationBuilder) {
            $relation = new ManyToOne(
                $associationBuilder->getBuilder(),
                $associationBuilder->getNamingStrategy(),
                'workflow',
                SaleWorkflow::class
            );
            return $relation;
        });
    }

}