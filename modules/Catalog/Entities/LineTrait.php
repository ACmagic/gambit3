<?php namespace Modules\Catalog\Entities;

use Modules\Core\Entities\Store;
use Modules\Prediction\Entities\Prediction;
use Carbon\Carbon;

trait LineTrait {

    protected $id;
    protected $store;
    protected $side;
    protected $odds;
    protected $createdAt;
    protected $updatedAt;
    protected $predictionsCache;
    protected $advertisedLines;
    protected $predictions;

    public function getId() {
        return $this->id;
    }

    public function getPredictions() {
        return $this->predictions;
    }

    public function addPrediction(Prediction $predication) {
        $this->predictions[] = $predication;
    }

    public function addAdvertisedLine(AdvertisedLine $advertisedLine) {
        $this->advertisedLines[] = $advertisedLine;
    }

    public function setStore(Store $store) {
        $this->store = $store;
    }

    public function getStore() {
        return $this->store;
    }

    public function setSide(Side $side) {
        $this->side = $side;
    }

    public function getSide() {
        return $this->side;
    }

    public function getOdds() {
        return $this->odds;
    }

    public function setOdds($odds) {
        $this->odds = $odds;
    }

    public function getPredictionsCache() : array {
        return $this->predictionsCache;
    }

    public function setPredictionsCache(array $predictionsCache) {
        $this->predictionsCache = $predictionsCache;
    }

    public function getCreatedAt() : Carbon {
        return $this->createdAt;
    }

    public function setCreatedAt(Carbon $createdAt) {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt() : Carbon {
        return $this->updatedAt;
    }

    public function setUpdatedAt(Carbon $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function doRebuildPredictionsCache() {

        $this->predictionsCache = [];

        foreach($this->getPredictions() as $prediction) {
            $this->predictionsCache[] = $prediction;
        }

    }

}