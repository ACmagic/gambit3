<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\QuoteMoneyLine;
use Modules\Vegas\Mappings\MoneyLineMappingTrait;

class QuoteMoneyLineMapping extends EntityMapping {

    use MoneyLineMappingTrait;

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return QuoteMoneyLine::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('quote_money_lines');
        $this->mapMoneyLine($builder);
    }

}