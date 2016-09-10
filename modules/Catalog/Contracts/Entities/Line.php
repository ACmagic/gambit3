<?php namespace Modules\Catalog\Contracts\Entities;

use Modules\Core\Entities\Store;
use Modules\Prediction\Entities\Prediction;
use Carbon\Carbon;
use Modules\Catalog\Entities\AdvertisedLine;
use Modules\Catalog\Entities\Side;

interface Line {

    public function getId();
    public function getPredictions();
    public function addPrediction(Prediction $predication);
    public function addAdvertisedLine(AdvertisedLine $advertisedLine);
    public function setStore(Store $store);
    public function getStore();
    public function setSide(Side $side);
    public function getSide();
    public function getOdds();
    public function setOdds($odds);
    public function getPredictionsCache() : array;
    public function setPredictionsCache(array $predictionsCache);
    public function getCreatedAt() : Carbon;
    public function setCreatedAt(Carbon $createdAt);
    public function getUpdatedAt() : Carbon;
    public function setUpdatedAt(Carbon $updatedAt);
    public function doRebuildPredictionsCache();

}