<?php namespace Modules\Catalog\Entities;

trait AdvertisedLineTrait {

    protected $inventory;
    protected $amount;
    protected $amountMax;

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

}