<?php namespace Modules\Catalog\Entities;

trait AdvertisedLineTrait {

    protected $side;

    protected $odds;
    protected $inventory;
    protected $amount;
    protected $amountMax;

    protected $acceptedLines;

    /**
     * Set the side.
     *
     * @param Side
     */
    public function setSide(Side $side) {
        $this->side = $side;
    }

    /**
     * Get the side.
     *
     * @return Side
     */
    public function getSide() {
        return $this->side;
    }

    public function setOdds($odds) {
        $this->odds = $odds;
    }

    public function getOdds() {
        return $this->odds;
    }

    public function getInventory() {
        return $this->inventory;
    }

    public function setInventory($inventory) {
        $this->inventory = $inventory;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getAmountMax() {
        return $this->amountMax;
    }

    public function setAmountMax($amountMax) {
        $this->amountMax = $amountMax;
    }

    public function getAcceptedLines() {
        return $this->acceptedLines;
    }

}