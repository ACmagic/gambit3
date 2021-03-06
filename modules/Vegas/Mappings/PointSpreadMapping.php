<?php namespace Modules\Vegas\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Vegas\Entities\PointSpread;
use LaravelDoctrine\Fluent\Fluent;

class PointSpreadMapping extends EntityMapping {

    use PointSpreadMappingTrait;

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return PointSpread::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('point_spreads');
        $this->mapPointSpread($builder);
    }

}