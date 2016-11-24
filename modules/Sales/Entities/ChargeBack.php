<?php namespace Modules\Sales\Entities;

use Carbon\Carbon;

class ChargeBack {

    protected $id;
    protected $sale;
    protected $payback;
    protected $memo;
    protected $amount;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function getSale() : Sale {
        return $this->sale;
    }

    public function setSale(Sale $sale) {
        $this->sale = $sale;
    }

    public function getPayback() : bool {
        return $this->payback;
    }

    public function setPayback(bool $payback) {
        $this->payback = $payback;
    }

    public function getMemo() : string {
        return $this->memo;
    }

    public function setMemo(string $memo) {
        $this->memo = $memo;
    }

    public function getAmount() : float {
        return $this->amount;
    }

    public function setAmount(float $amount) {
        $this->amount = $amount;
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

}