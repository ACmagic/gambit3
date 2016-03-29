<?php namespace Modules\Sales\Entities;

class QuotePrediction {

    protected $id;
    protected $advertisedLine;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function setAdvertisedLine(QuoteAdvertisedLine $advertisedLine) {
        $this->advertisedLine = $advertisedLine;
    }

    public function getAdvertisedLine() {
        return $this->advertisedLine;
    }

}