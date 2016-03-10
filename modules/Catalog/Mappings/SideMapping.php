<?php namespace Modules\Catalog\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Catalog\Entities\Side;
use LaravelDoctrine\Fluent\Fluent;

class SideMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Side::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('sides');
        $builder->smallIncrements('id');
        $builder->string('machineName')->length(128)->default('')->unique();
        $builder->string('humanName')->length(128)->default('')->unique();
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
    }

}