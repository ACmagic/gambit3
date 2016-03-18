<?php namespace Modules\Vegas\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Vegas\Entities\PointSpread;
use Modules\Sports\Entities\Team;
use LaravelDoctrine\Fluent\Fluent;

class PointSpreadMapping extends EntityMapping {

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
        $builder->float('spread')->precision(5)->scale(1)->default(0.5);
        $builder->belongsTo(Team::class,'pick');
    }

}