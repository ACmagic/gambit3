<?php namespace Modules\Core\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Core\Entities\User;
use LaravelDoctrine\Fluent\Fluent;

class UserMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return User::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('users');
        $builder->increments('id');
        $builder->string('email');
        $builder->string('password')->length(60);
        $builder->rememberToken('rememberToken');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
    }

}