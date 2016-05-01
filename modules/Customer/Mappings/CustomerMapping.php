<?php namespace Modules\Customer\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Entities\CustomerPool;
use Modules\Accounting\Entities\Account;
use LaravelDoctrine\Fluent\Fluent;

class CustomerMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Customer::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('customers');
        $builder->bigIncrements('id');
        $builder->string('email');
        $builder->string('password')->length(60);
        $builder->manyToOne(CustomerPool::class,'pool');
        $builder->manyToMany(Account::class,'accounts')->joinTable('customer_accounts')->cascadePersist();
        $builder->rememberToken('rememberToken');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
    }

}