<?php namespace Modules\Catalog\Contracts\Entities;

use Modules\Core\Entities\Store;
use Modules\Prediction\Entities\Prediction;
use Carbon\Carbon;
use Modules\Catalog\Entities\AdvertisedLine;
use Modules\Catalog\Entities\Side;
use Modules\Catalog\Entities\LineWorkflowState;
use Modules\Catalog\Entities\LineWorkflowTransition;

interface Line {

    public function getId();
    public function getPredictions();
    public function addPrediction(Prediction $predication);
    public function addAdvertisedLine(AdvertisedLine $advertisedLine);
    public function setStore(Store $store);
    public function getStore();
    public function setSide(Side $side);
    public function getSide();
    public function setWinningSide(Side $winningSide);
    public function getWinningSide() /*: ?Side*/;
    public function getOdds();
    //public function getInverseOdds();
    public function setOdds($odds);
    //public function setInverseOdds($inverseOdds);
    public function getPredictionsCache() : array;
    public function setPredictionsCache(array $predictionsCache);
    public function getCreatedAt() : Carbon;
    public function setCreatedAt(Carbon $createdAt);
    public function getUpdatedAt() : Carbon;
    public function setUpdatedAt(Carbon $updatedAt);
    public function getState() : LineWorkflowState;
    public function setState(LineWorkflowState $state);
    public function addTransition(LineWorkflowTransition $transition);
    public function doRebuildPredictionsCache();

    // Cached aggregate calculations
    public function getRollingInventory() : int;
    public function setRollingInventory(int $rollingInventory);
    public function getRollingAmount();
    public function setRollingAmount($rollingAmount);
    public function getRollingAmountMax();
    public function setRollingAmountMax($rollingAmountMax);
    public function getRealTimeInventory() : int;
    public function setRealTimeInventory(int $realTimeInventory);
    public function getRealTimeAmount();
    public function setRealTimeAmount($realTimeAmount);
    public function getRealTimeAmountMax();
    public function setRealTimeAmountMax($realTimeAmountMax);

}