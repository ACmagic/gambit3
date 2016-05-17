<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\Quote;
use Modules\Sales\Entities\Sale;
use Modules\Core\Entities\Site;
use Modules\Customer\Entities\Customer;
use Modules\Sales\Entities\QuoteItem;

class QuoteMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Quote::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {

        $builder->table('quotes');
        $builder->bigIncrements('id');
        $builder->string('sessionId');
        $builder->boolean('isCart')->nullable();
        $builder->boolean('isExpired')->default(false);
        $builder->belongsTo(Site::class,'site');
        $builder->belongsTo(Customer::class,'customer')->nullable();
        $builder->belongsTo(Sale::class,'sale')->nullable();
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
        $builder->timestamp('expiredAt')->nullable();

        // Quote Items
        $builder->hasMany(QuoteItem::class,'items')->mappedBy('quote')->cascadePersist();
    }

}