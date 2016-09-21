<?php namespace Modules\Catalog\Entities;

trait AcceptedLineTrait {

    protected $advertisedLine;
    protected $amount;
    protected $quantity;

    public function getAdvertisedLine() {
        return $this->advertisedLine;
    }

    public function setAdvertisedLine(AdvertisedLine $advertisedLine) {
        $this->advertisedLine = $advertisedLine;
    }

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function getQuantity() {
        return $this->quantity;
    }

}