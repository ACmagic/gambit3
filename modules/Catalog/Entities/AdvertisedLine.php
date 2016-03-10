<?php namespace Modules\Catalog\Entities;

use Modules\Customer\Entities\Customer;

class AdvertisedLine {

    protected $id;
    protected $line;
    protected $customer;
    protected $inventory;
    protected $amount;
    protected $amountMax;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function getLine() {
        return $this->line;
    }

    public function setLine(Line $line) {
        $this->line = $line;
    }

    public function getCustomer() {
        return $this->customer;
    }

    public function setCustomer(Customer $customer) {
        $this->customer = $customer;
    }

    public function getInventory() {
        return $this->inventory;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getAmountMax() {
        return $this->amountMax;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

}