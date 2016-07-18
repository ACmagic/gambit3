<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\SaleAdvertisedLine;
use Modules\Catalog\Mappings\AdvertisedLineMappingTrait;
use Modules\Sales\Entities\SalePrediction;

class SaleAdvertisedLineMapping extends EntityMapping {

    use AdvertisedLineMappingTrait;

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return SaleAdvertisedLine::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('sale_advertised_lines');
        $builder->hasMany(SalePrediction::class,'predictions')->mappedBy('advertisedLine')->cascadePersist();
        $builder->jsonArray('predictionsCache');
        
        $this->mapAdvertisedLine($builder);

        $builder->events()->prePersist('doRebuildPredictionsCache');
        $builder->events()->preUpdate('doRebuildPredictionsCache');
    }

}