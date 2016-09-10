<?php namespace Modules\Vegas\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Vegas\Entities\InversePointSpread;
use LaravelDoctrine\Fluent\Fluent;

class InversePointSpreadMapping extends EntityMapping {

    use PointSpreadMappingTrait;

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return InversePointSpread::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('point_spreads');
        $builder->entity()->readOnly();
        $this->mapPointSpread($builder);
    }

}