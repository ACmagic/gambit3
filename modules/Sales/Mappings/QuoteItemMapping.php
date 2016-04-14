<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\QuoteItem;
use Modules\Sales\Entities\Quote;
use Modules\Sales\Entities\QuoteAdvertisedLine;
use Modules\Sales\Entities\QuoteAcceptedLine;
use Modules\Sales\Entities\QuoteCredit;

class QuoteItemMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return QuoteItem::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {

        $builder->table('quote_items');
        $builder->bigIncrements('id');
        $builder->belongsTo(Quote::class,'quote');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        $builder->joinedTableInheritance()
            ->column('type')
            ->map(QuoteItem::class,QuoteItem::class)
            ->map(QuoteAdvertisedLine::class,QuoteAdvertisedLine::class)
            ->map(QuoteAcceptedLine::class,QuoteAcceptedLine::class)
            ->map(QuoteCredit::class,QuoteCredit::class);
    }

}