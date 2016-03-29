<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\QuotePrediction;
use Modules\Sales\Entities\QuoteAdvertisedLine;
use Modules\Sales\Entities\QuoteMoneyLine;
use Modules\Sales\Entities\QuotePointSpread;

class QuotePredictionMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return QuotePrediction::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {

        $builder->table('quote_predictions');
        $builder->bigIncrements('id');
        $builder->belongsTo(QuoteAdvertisedLine::class,'advertisedLine');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        $builder->joinedTableInheritance()
            ->column('type')
            ->map(QuotePrediction::class,QuotePrediction::class)
            ->map(QuoteMoneyLine::class,QuoteMoneyLine::class)
            ->map(QuotePointSpread::class,QuotePointSpread::class);
    }

}