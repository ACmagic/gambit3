<?php namespace Modules\Catalog\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Core\Entities\Store;
use Modules\Catalog\Entities\Side;
use Modules\Catalog\Entities\InverseLine;
use Modules\Catalog\Entities\AdvertisedLine;
use Modules\Prediction\Entities\InversePrediction;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Catalog\Entities\LineWorkflowTransition;
use Modules\Catalog\Entities\LineWorkflowState;

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
        $builder->belongsTo(Side::class,'winningSide')->nullable();
        $builder->belongsTo(LineWorkflowState::class,'state');
        $builder->hasMany(AdvertisedLine::class,'advertisedLines')->mappedBy('line')->fetchExtraLazy();
        $builder->hasMany(InversePrediction::class,'predictions')->mappedBy('line')->fetchExtraLazy();
        $builder->jsonArray('predictionsCache');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        $builder->integer('odds')->default(0);
        //$builder->integer('inverseOdds')->name('odds')->default(0);

        // Cached aggregate values
        $builder->unsignedBigInteger('rollingInventory')->default(0);
        $builder->decimal('rollingAmount')->unsigned()->precision(16)->scale(4)->default(0);
        $builder->decimal('rollingAmountMax')->unsigned()->precision(16)->scale(4)->nullable();
        $builder->unsignedBigInteger('realTimeInventory')->name('realtime_inventory')->default(0);
        $builder->decimal('realTimeAmount')->name('realtime_amount')->unsigned()->precision(16)->scale(4)->default(0);
        $builder->decimal('realTimeAmountMax')->name('realtime_amount_max')->unsigned()->precision(16)->scale(4)->nullable();

        // Transitions
        $builder->hasMany(LineWorkflowTransition::class,'transitions')->mappedBy('line')->fetchExtraLazy()->cascadePersist();

        $builder->entity()->readOnly();


    }

}