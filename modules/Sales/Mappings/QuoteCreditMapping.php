<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\QuoteCredit;

class QuoteCreditMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return QuoteCredit::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('quote_credits');
        $builder->decimal('amount')->unsigned()->precision(16)->scale(4);
    }

}