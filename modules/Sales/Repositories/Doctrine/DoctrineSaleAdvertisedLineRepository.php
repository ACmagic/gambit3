<?php namespace Modules\Sales\Repositories\Doctrine;

use Modules\Sales\Repositories\SaleAdvertisedLineRepository;
use Modules\Sales\Entities\SaleAdvertisedLine;

class DoctrineSaleAdvertisedLineRepository extends DoctrineSaleItemRepository implements SaleAdvertisedLineRepository {

    /**
     * Find a sale advertised line item by matching it to a concrete
     * advertised line by id.
     *
     * @param int $advertisedLineId
     *   The advertied line id.
     *
     * @return ?SaleAdvertisedLine
     */
    public function findByAdvertisedLineId(int $advertisedLineId) : ?SaleAdvertisedLine {
        return $this->genericRepository->findOneByAdvertisedLineId($advertisedLineId);
    }

}