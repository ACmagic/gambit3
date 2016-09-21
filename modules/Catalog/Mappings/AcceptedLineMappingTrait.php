<?php namespace Modules\Catalog\Mappings;

use LaravelDoctrine\Fluent\Fluent;
use Modules\Catalog\Entities\AdvertisedLine;

trait AcceptedLineMappingTrait {

    protected function mapAcceptedLine(Fluent $builder) {

        $builder->belongsTo(AdvertisedLine::class,'advertisedLine');
        $builder->decimal('amount')->unsigned()->precision(16)->scale(4);
        $builder->unsignedBigInteger('quantity')->default(1);

    }

}