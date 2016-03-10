<?php namespace Modules\Catalog\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Customer\Entities\Customer;
use Modules\Catalog\Entities\AdvertisedLine;
use Modules\Catalog\Entities\AcceptedLine;
use LaravelDoctrine\Fluent\Fluent;

class AcceptedLineMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return AcceptedLine::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('accepted_lines');
        $builder->bigIncrements('id');

        $builder->belongsTo(AdvertisedLine::class,'advertisedLine');
        $builder->belongsTo(Customer::class,'customer');

        $builder->decimal('amount')->unsigned()->precision(16)->scale(4);

        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
    }

}