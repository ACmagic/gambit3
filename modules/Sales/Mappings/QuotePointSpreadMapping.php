<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\QuotePointSpread;
use Modules\Vegas\Mappings\PointSpreadMappingTrait;

class QuotePointSpreadMapping extends EntityMapping {

    use PointSpreadMappingTrait;

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return QuotePointSpread::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('quote_point_spreads');
        $this->mapPointSpread($builder);
    }

}