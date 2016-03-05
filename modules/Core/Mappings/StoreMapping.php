<?php namespace Modules\Core\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Core\Entities\Store;
use Modules\Core\Entities\Site;
use Modules\Core\Entities\User;
use LaravelDoctrine\Fluent\Fluent;

class StoreMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Store::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('stores');
        $builder->increments('id');
        $builder->manyToOne(User::class,'creator');
        $builder->manyToOne(Site::class,'site')->inversedBy('stores');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
    }

}