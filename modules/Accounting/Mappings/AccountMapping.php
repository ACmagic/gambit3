<?php namespace Modules\Accounting\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Accounting\Entities\Account;
use Modules\Accounting\Entities\AccountType;

class AccountMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Account::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('accounts');
        $builder->bigIncrements('id');
        $builder->decimal('balance')->precision(19)->scale(4);
        $builder->belongsTo(AccountType::class,'type');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
    }

}