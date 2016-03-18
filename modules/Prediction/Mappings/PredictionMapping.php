<?php namespace Modules\Prediction\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Prediction\Entities\Prediction;
use Modules\Catalog\Entities\Line;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Vegas\Entities\MoneyLine;
use Modules\Vegas\Entities\PointSpread;

class PredictionMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Prediction::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('predictions');
        $builder->increments('id');
        $builder->belongsTo(Line::class,'line');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        $builder->joinedTableInheritance()
            ->column('type')
            ->map(Prediction::class,Prediction::class)
            ->map(MoneyLine::class,MoneyLine::class)
            ->map(PointSpread::class,PointSpread::class);
    }

}