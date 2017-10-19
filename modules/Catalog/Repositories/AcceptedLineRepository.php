<?php namespace Modules\Catalog\Repositories;

interface AcceptedLineRepository {

    public function findById($id);
    public function findAll();

    /**
     * Calculate sum of amounts for all accepted lines belonging
     * to the passed advertised line id.
     *
     * @param int $advertisedLineId
     *   The advertiesed line id.
     *
     * @return int
     */
    public function sumTotalAmountByAdvertisedLineId(int $advertisedLineId): int;

}