<?php namespace Modules\Catalog\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Catalog\Entities\LineWorkflowState;
use Modules\Catalog\Entities\LineWorkflow;
use LaravelDoctrine\Fluent\Fluent;
use LaravelDoctrine\Fluent\Relations\ManyToOne;

class LineWorkflowStateMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return LineWorkflowState::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('line_workflow_states');

        // Make workflow associated with sale workflow.
        $builder->override('workflow',function(ManyToOne $associationBuilder) {
            $relation = new ManyToOne(
                $associationBuilder->getBuilder(),
                $associationBuilder->getNamingStrategy(),
                'workflow',
                LineWorkflow::class
            );
            return $relation;
        });
    }

}