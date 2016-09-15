<?php namespace Modules\Catalog\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Catalog\Entities\LineWorkflowTransition;
use Modules\Catalog\Entities\LineWorkflowState;
use Modules\Catalog\Entities\Line;
use LaravelDoctrine\Fluent\Fluent;
use LaravelDoctrine\Fluent\Relations\ManyToOne;

class LineWorkflowTransitionMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return LineWorkflowTransition::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('line_workflow_transitions');

        $builder->belongsTo(Line::class,'line');

        // Restrict state associations to sale workflow states.
        $builder->override('beforeState',function(ManyToOne $associationBuilder) {
            $relation = new ManyToOne(
                $associationBuilder->getBuilder(),
                $associationBuilder->getNamingStrategy(),
                'beforeState',
                LineWorkflowState::class
            );
            return $relation;
        });

        $builder->override('afterState',function(ManyToOne $associationBuilder) {
            $relation = new ManyToOne(
                $associationBuilder->getBuilder(),
                $associationBuilder->getNamingStrategy(),
                'afterState',
                LineWorkflowState::class
            );
            return $relation;
        });

    }

}