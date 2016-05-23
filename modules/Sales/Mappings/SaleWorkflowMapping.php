<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Sales\Entities\SaleWorkflow;
use LaravelDoctrine\Fluent\Fluent;

class SaleWorkflowMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return SaleWorkflow::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('sale_workflows');
    }

}