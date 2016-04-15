<?php namespace Modules\Sales\Entities;

use Carbon\Carbon;

class SalePrediction {

    protected $id;
    protected $advertisedLine;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function setAdvertisedLine(SaleAdvertisedLine $advertisedLine) {
        $this->advertisedLine = $advertisedLine;
    }

    public function getAdvertisedLine() {
        return $this->advertisedLine;
    }

    public function setCreatedAt(Carbon $createdAt) {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setUpdatedAt(Carbon $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

}