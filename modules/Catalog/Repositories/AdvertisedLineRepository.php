<?php namespace Modules\Catalog\Repositories;

use Modules\Catalog\Contracts\Entities\Line as LineContract;
use Modules\Catalog\Entities\AdvertisedLine;

interface AdvertisedLineRepository {

    public function findById($id);
    public function findAll();

    /**
     * Find the first available advertised line.
     *
     * @param LineContract $line
     *   The line.
     *
     * @param float $amount
     *   The amount.
     *
     * @param int $quantity
     *   The quantity.
     *
     * @return array
     *   The matched line.
     *
     */
    public function matchAvailable(LineContract $line,$amount,$quantity);

    /**
     * Calculate the left over inventory for the specified advertised line.
     *
     * @param int $advertisedLineId
     *   The advertised line id.
     *
     * @return int
     */
    public function calculateAvailableInventory(int $advertisedLineId) : int;

    /**
     * Calculate the available amount.
     *
     * @param int $advertisedLineId
     *   The advertised line id.
     *
     * @return float
     */
    public function calculateAvailableAmount(int $advertisedLineId) : float;

    /**
     * Fetch ids of all advertised lines that have left over inventory by
     * the specified line id.
     *
     * @param int $lineId
     *   The line id.
     *
     * @return array
     */
    public function findAllIdsWithLeftOverInventoryByLineId(int $lineId) : array;

    /**
     * Fetch ids of all advertised lines that have left over amounts by
     * the specified line id.
     *
     * @param int $lineId
     *   The line id.
     *
     * @return array
     */
    public function findAllIdsWithLeftOverAmountsByLineId(int $lineId) : array;

}