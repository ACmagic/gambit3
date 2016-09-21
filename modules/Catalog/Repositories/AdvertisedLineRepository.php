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

}