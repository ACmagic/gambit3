<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\Sale;
use Modules\Sales\Entities\SaleWorkflowState;
use Modules\Sales\Entities\SaleWorkflowTransition;
use Modules\Core\Entities\Store;
use Modules\Customer\Entities\Customer;
use Modules\Sales\Entities\SaleItem;
use Modules\Sales\Entities\ChargeBack;
use Modules\Accounting\Entities\Posting as PostingEntity;

class SaleMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Sale::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {

        $builder->table('sales');
        $builder->bigIncrements('id');
        $builder->belongsTo(Store::class,'store');
        $builder->belongsTo(Customer::class,'customer');
        $builder->belongsTo(SaleWorkflowState::class,'state');
        $builder->manyToMany(PostingEntity::class,'transactions')->joinTable('sale_transactions')->cascadePersist();
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        // Sale Items
        $builder->hasMany(SaleItem::class,'items')->mappedBy('sale')->cascadePersist();

        // Transitions
        $builder->hasMany(SaleWorkflowTransition::class,'transitions')->mappedBy('sale')->fetchExtraLazy()->cascadePersist();

        // Charge backs
        $builder->hasMany(ChargeBack::class,'chargeBacks')->mappedBy('sale')->fetchExtraLazy()->cascadePersist();
    }

}