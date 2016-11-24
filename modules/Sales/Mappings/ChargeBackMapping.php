<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\ChargeBack;
use Modules\Sales\Entities\Sale;

class ChargeBackMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return ChargeBack::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {

        $builder->table('charge_backs');
        $builder->bigIncrements('id');
        $builder->belongsTo(Sale::class,'sale');
        $builder->text('memo');
        $builder->decimal('amount')->unsigned()->precision(16)->scale(4);
        $builder->boolean('payback')->default(false);
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

    }

}