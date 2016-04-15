<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\SaleMoneyLine;
use Modules\Vegas\Mappings\MoneyLineMappingTrait;

class SaleMoneyLineMapping extends EntityMapping {

    use MoneyLineMappingTrait;

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return SaleMoneyLine::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('sale_money_lines');
        $this->mapMoneyLine($builder);
    }

}