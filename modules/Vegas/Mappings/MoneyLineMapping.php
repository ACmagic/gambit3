<?php namespace Modules\Vegas\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Vegas\Entities\MoneyLine;
use LaravelDoctrine\Fluent\Fluent;

class MoneyLineMapping extends EntityMapping {

    use MoneyLineMappingTrait;

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return MoneyLine::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('money_lines');
        $this->mapMoneyLine($builder);
    }

}