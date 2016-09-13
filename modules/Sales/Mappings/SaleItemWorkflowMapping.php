<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Sales\Entities\SaleItemWorkflow;
use LaravelDoctrine\Fluent\Fluent;

class SaleItemWorkflowMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return SaleItemWorkflow::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('sale_item_workflows');
    }

}