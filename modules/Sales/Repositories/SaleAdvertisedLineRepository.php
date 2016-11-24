<?php namespace Modules\Sales\Repositories;

use Modules\Sales\Entities\SaleAdvertisedLine;

interface SaleAdvertisedLineRepository extends SaleItemRepository {

    /**
     * Find a sale advertised line item by matching it to a concrete
     * advertised line by id.
     *
     * @param int $advertisedLineId
     *   The advertied line id.
     *
     * @return ?SaleAdvertisedLine
     */
    public function findByAdvertisedLineId(int $advertisedLineId) : ?SaleAdvertisedLine;

}