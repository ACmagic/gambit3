<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\QuoteAdvertisedLine;
use Modules\Catalog\Mappings\AdvertisedLineMappingTrait;

class QuoteAdvertisedLineMapping extends EntityMapping {

    use AdvertisedLineMappingTrait;

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return QuoteAdvertisedLine::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('quote_advertised_lines');
        $this->mapAdvertisedLine($builder);
    }

}