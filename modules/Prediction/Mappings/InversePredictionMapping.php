<?php namespace Modules\Prediction\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Prediction\Entities\InversePrediction;
use Modules\Catalog\Entities\InverseLine;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Vegas\Entities\InverseMoneyLine;
use Modules\Vegas\Entities\InversePointSpread;

class InversePredictionMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return InversePrediction::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('predictions');
        $builder->increments('id');
        $builder->belongsTo(InverseLine::class,'line');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        $builder->entity()->readOnly();

        $builder->joinedTableInheritance()
            ->column('inverse_type')
            ->map(InversePrediction::class,InversePrediction::class)
            ->map(InverseMoneyLine::class,InverseMoneyLine::class)
            ->map(InversePointSpread::class,InversePointSpread::class);
    }

}