<?php namespace Modules\Catalog\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Catalog\Entities\LineWorkflow;
use LaravelDoctrine\Fluent\Fluent;

class LineWorkflowMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return LineWorkflow::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('line_workflows');
    }

}