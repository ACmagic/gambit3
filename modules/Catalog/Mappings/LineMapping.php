<?php namespace Modules\Catalog\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Core\Entities\Store;
use Modules\Catalog\Entities\Side;
use Modules\Catalog\Entities\Line;
use Modules\Catalog\Entities\AdvertisedLine;
use Modules\Prediction\Entities\Prediction;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Catalog\Entities\LineWorkflowTransition;
use Modules\Catalog\Entities\LineWorkflowState;

class LineMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Line::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('`lines`');
        $builder->bigIncrements('id');
        $builder->belongsTo(Store::class,'store');
        $builder->belongsTo(Side::class,'side');
        $builder->belongsTo(LineWorkflowState::class,'state');
        $builder->hasMany(AdvertisedLine::class,'advertisedLines')->mappedBy('line')->fetchExtraLazy()->cascadePersist();
        $builder->hasMany(Prediction::class,'predictions')->mappedBy('line')->fetchExtraLazy()->cascadePersist();
        $builder->integer('odds')->default(0);
        $builder->jsonArray('predictionsCache');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        // Transitions
        $builder->hasMany(LineWorkflowTransition::class,'transitions')->mappedBy('line')->fetchExtraLazy()->cascadePersist();

        $builder->events()->prePersist('doRebuildPredictionsCache');
        $builder->events()->preUpdate('doRebuildPredictionsCache');


    }

}