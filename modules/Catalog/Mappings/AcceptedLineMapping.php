<?php namespace Modules\Catalog\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Customer\Entities\Customer;
use Modules\Catalog\Entities\AcceptedLine;
use LaravelDoctrine\Fluent\Fluent;

class AcceptedLineMapping extends EntityMapping {

    use AcceptedLineMappingTrait;

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

        $builder->belongsTo(Customer::class,'customer');

        $this->mapAcceptedLine($builder);

        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
    }

}