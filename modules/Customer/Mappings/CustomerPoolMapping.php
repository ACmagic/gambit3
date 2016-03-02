<?php namespace Modules\Customer\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Customer\Entities\CustomerPool;
use Modules\Core\Entities\Site;
use LaravelDoctrine\Fluent\Fluent;

class CustomerPoolMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return CustomerPool::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('customer_pool');
        $builder->increments('id');
        $builder->oneToOne(Site::class,'site');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
    }

}