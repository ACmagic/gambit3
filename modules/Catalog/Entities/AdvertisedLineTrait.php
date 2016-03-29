<?php namespace Modules\Catalog\Entities;

trait AdvertisedLineTrait {

    protected $inventory;
    protected $amount;
    protected $amountMax;

    public function getInventory() {
        return $this->inventory;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getAmountMax() {
        return $this->amountMax;
    }

}