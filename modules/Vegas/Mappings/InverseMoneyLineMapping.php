<?php namespace Modules\Vegas\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Vegas\Entities\InverseMoneyLine;
use LaravelDoctrine\Fluent\Fluent;

class InverseMoneyLineMapping extends EntityMapping {

    use MoneyLineMappingTrait;

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return InverseMoneyLine::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('money_lines');
        $builder->entity()->readOnly();
        $this->mapMoneyLine($builder);
    }

}