<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\SalePrediction;
use Modules\Sales\Entities\SaleAdvertisedLine;
use Modules\Sales\Entities\SaleMoneyLine;
use Modules\Sales\Entities\SalePointSpread;

class SalePredictionMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return SalePrediction::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {

        $builder->table('sale_predictions');
        $builder->bigIncrements('id');
        $builder->belongsTo(SaleAdvertisedLine::class,'advertisedLine');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        $builder->joinedTableInheritance()
            ->column('type')
            ->map(SalePrediction::class,SalePrediction::class)
            ->map(SaleMoneyLine::class,SaleMoneyLine::class)
            ->map(SalePointSpread::class,SalePointSpread::class);
    }

}