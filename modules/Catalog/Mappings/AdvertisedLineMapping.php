<?php namespace Modules\Catalog\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Customer\Entities\Customer;
use Modules\Catalog\Entities\Line;
use Modules\Catalog\Entities\AdvertisedLine;
use LaravelDoctrine\Fluent\Fluent;

class AdvertisedLineMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return AdvertisedLine::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('advertised_lines');
        $builder->bigIncrements('id');

        $builder->belongsTo(Line::class,'line');
        $builder->belongsTo(Customer::class,'customer');

        $builder->unsignedBigInteger('inventory')->default(1);
        $builder->decimal('amount')->unsigned()->precision(16)->scale(4);
        $builder->decimal('amountMax')->unsigned()->precision(16)->scale(4)->nullable();

        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
    }

}