<?php namespace Modules\Core\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Core\Entities\Site;
use Modules\Core\Entities\User;
use LaravelDoctrine\Fluent\Fluent;

class SiteMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Site::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('sites');
        $builder->increments('id');
        $builder->manyToOne(User::class,'creator');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
    }

}