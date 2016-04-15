<?php namespace Modules\Sales\Entities;

use Carbon\Carbon;

class SaleItem {

    protected $id;
    protected $sale;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function setSale(Sale $sale) {
        $this->sale = $sale;
    }

    public function getSale() {
        return $this->sale;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setCreatedAt(Carbon $createdAt) {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(Carbon $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

}