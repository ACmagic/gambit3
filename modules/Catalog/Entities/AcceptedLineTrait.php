<?php namespace Modules\Catalog\Entities;

trait AcceptedLineTrait {

    protected $advertisedLine;
    protected $amount;

    public function getAdvertisedLine() {
        return $this->advertisedLine;
    }

    public function setAdvertisedLine(AdvertisedLine $advertisedLine) {
        $this->advertisedLine = $advertisedLine;
    }

    public function getAmount() {
        return $this->amount;
    }

}