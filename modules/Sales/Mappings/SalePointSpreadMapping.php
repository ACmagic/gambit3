<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\SalePointSpread;
use Modules\Vegas\Mappings\PointSpreadMappingTrait;

class SalePointSpreadMapping extends EntityMapping {

    use PointSpreadMappingTrait;

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return SalePointSpread::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('sale_point_spreads');
        $this->mapPointSpread($builder);
    }

}