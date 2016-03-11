<?php namespace Modules\Event\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Event\Entities\Category;
use Modules\Core\Entities\User;
use LaravelDoctrine\Fluent\Fluent;

class CategoryMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Category::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {

        $builder->table('categories');
        $builder
            ->tree()
            ->asNestedSet()
            ->right('rgt')
            ->left('lft')
            ->root('root')
            ->parent('parent')
            ->level('lvl');
        $builder->hasMany(Category::class,'children')->mappedBy('parent')->orderBy('lft','ASC');

        $builder->bigIncrements('id');
        $builder->manyToOne(User::class,'creator');
        $builder->string('machineName')->length(128)->default('')->unique();
        $builder->string('humanName')->length(128)->default('')->unique();

        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

    }

}