<?php namespace Modules\Workflow\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Workflow\Entities\Workflow;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\SaleWorkflow;
use Modules\Sales\Entities\SaleItemWorkflow;
use Modules\Catalog\Entities\LineWorkflow;
use Modules\Event\Entities\EventWorkflow;

class WorkflowMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Workflow::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('workflows');
        $builder->bigIncrements('id');
        $builder->string('machineName')->length(128)->default('')->unique();
        $builder->string('humanName')->length(128)->default('')->unique();
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        $builder->joinedTableInheritance()
            ->column('type')
            ->map(Workflow::class,Workflow::class)
            ->map(SaleWorkflow::class,SaleWorkflow::class)
            ->map(SaleItemWorkflow::class,SaleItemWorkflow::class)
            ->map(LineWorkflow::class,LineWorkflow::class)
            ->map(EventWorkflow::class,EventWorkflow::class);
    }

}