<?php namespace Modules\Catalog\Entities;

use Modules\Core\Entities\Store;
use Modules\Prediction\Entities\Prediction;
use Carbon\Carbon;

trait LineTrait {

    protected $id;
    protected $store;
    protected $side;
    protected $odds;
    //protected $inverseOdds;
    protected $createdAt;
    protected $updatedAt;
    protected $predictionsCache;
    protected $advertisedLines;
    protected $predictions;
    protected $transitions;
    protected $state;

    // Cached aggregate calculations
    protected $rollingInventory;
    protected $rollingAmount;
    protected $rollingAmountMax;
    protected $realTimeInventory;
    protected $realTimeAmount;
    protected $realTimeAmountMax;

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

    /*public function getInverseOdds() {
        return $this->inverseOdds;
    }*/

    /*public function setInverseOdds($inverseOdds) {
        $this->inverseOdds = $inverseOdds;
    }*/

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

    public function getState() : LineWorkflowState {
        return $this->state;
    }

    public function setState(LineWorkflowState $state) {
        $this->state = $state;
    }

    public function addTransition(LineWorkflowTransition $transition) {
        $this->transitions[] = $transition;
    }

    public function doRebuildPredictionsCache() {

        $this->predictionsCache = [];

        foreach($this->getPredictions() as $prediction) {
            $this->predictionsCache[] = $prediction;
        }

    }

    /*
     * -------------------------------------------------------------------------------------------
     * Cached aggregated calculations
     * -------------------------------------------------------------------------------------------
     */

    public function getRollingInventory() : int {
        return $this->rollingInventory;
    }

    public function setRollingInventory(int $rollingInventory) {
        $this->rollingInventory = $rollingInventory;
    }

    public function getRollingAmount() {
        return $this->rollingAmount;
    }

    public function setRollingAmount($rollingAmount) {
        $this->rollingAmount = $rollingAmount;
    }

    public function getRollingAmountMax() {
        return $this->rollingAmountMax;
    }

    public function setRollingAmountMax($rollingAmountMax) {
        $this->rollingAmountMax = $rollingAmountMax;
    }

    public function getRealTimeInventory() : int {
        return $this->realTimeInventory;
    }

    public function setRealTimeInventory(int $realTimeInventory) {
        $this->realTimeInventory = $realTimeInventory;
    }

    public function getRealTimeAmount() {
        return $this->realTimeAmount;
    }

    public function setRealTimeAmount($realTimeAmount) {
        $this->realTimeAmount = $realTimeAmount;
    }

    public function getRealTimeAmountMax() {
        return $this->realTimeAmountMax;
    }

    public function setRealTimeAmountMax($realTimeAmountMax) {
        $this->realTimeAmountMax = $realTimeAmountMax;
    }

}