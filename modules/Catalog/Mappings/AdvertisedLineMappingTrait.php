<?php namespace Modules\Catalog\Mappings;

use LaravelDoctrine\Fluent\Fluent;

trait AdvertisedLineMappingTrait {

    protected function mapAdvertisedLine(Fluent $builder) {

        $builder->unsignedBigInteger('inventory')->default(1);
        $builder->decimal('amount')->unsigned()->precision(16)->scale(4);
        $builder->decimal('amountMax')->unsigned()->precision(16)->scale(4)->nullable();

    }

}