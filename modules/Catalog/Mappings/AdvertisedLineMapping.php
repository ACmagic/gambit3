<?php namespace Modules\Catalog\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Customer\Entities\Customer;
use Modules\Catalog\Entities\Line;
use Modules\Catalog\Entities\AdvertisedLine;
use LaravelDoctrine\Fluent\Fluent;

class AdvertisedLineMapping extends EntityMapping {

    use AdvertisedLineMappingTrait;

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

        $this->mapAdvertisedLine($builder);

        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
    }

}