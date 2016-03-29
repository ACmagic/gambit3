<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\QuoteAcceptedLine;
use Modules\Catalog\Mappings\AcceptedLineMappingTrait;

class QuoteAcceptedLineMapping extends EntityMapping {

    use AcceptedLineMappingTrait;

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return QuoteAcceptedLine::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('quote_accepted_lines');
        $this->mapAcceptedLine($builder);
    }

}