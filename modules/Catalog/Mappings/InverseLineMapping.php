<?php namespace Modules\Catalog\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Core\Entities\Store;
use Modules\Catalog\Entities\Side;
use Modules\Catalog\Entities\InverseLine;
use Modules\Catalog\Entities\AdvertisedLine;
use Modules\Prediction\Entities\InversePrediction;
use LaravelDoctrine\Fluent\Fluent;

class InverseLineMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return InverseLine::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('`lines`');
        $builder->bigIncrements('id');
        $builder->belongsTo(Store::class,'store');
        $builder->belongsTo(Side::class,'side');
        $builder->hasMany(AdvertisedLine::class,'advertisedLines')->mappedBy('line')->fetchExtraLazy();
        $builder->hasMany(InversePrediction::class,'predictions')->mappedBy('line')->fetchExtraLazy();
        $builder->integer('odds')->default(0);
        $builder->jsonArray('predictionsCache');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        $builder->entity()->readOnly();


    }

}