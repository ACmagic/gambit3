<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\Sale;
use Modules\Core\Entities\Store;
use Modules\Customer\Entities\Customer;
use Modules\Sales\Entities\SaleItem;
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
        $builder->manyToMany(PostingEntity::class,'transactions')->joinTable('sale_transactions')->cascadePersist();
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        // Sale Items
        $builder->hasMany(SaleItem::class,'items')->mappedBy('sale')->cascadePersist();
    }

}