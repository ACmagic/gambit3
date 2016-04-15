<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\SaleAcceptedLine;
use Modules\Catalog\Mappings\AcceptedLineMappingTrait;

class SaleAcceptedLineMapping extends EntityMapping {

    use AcceptedLineMappingTrait;

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return SaleAcceptedLine::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('sale_accepted_lines');
        $this->mapAcceptedLine($builder);
    }

}