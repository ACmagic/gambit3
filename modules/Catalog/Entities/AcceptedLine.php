<?php namespace Modules\Catalog\Entities;

use Modules\Customer\Entities\Customer;

class AcceptedLine {

    protected $id;
    protected $advertisedLine;
    protected $customer;
    protected $amount;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function getAdvertisedLine() {
        return $this->advertisedLine;
    }

    public function setAdvertisedLine(AdvertisedLine $advertisedLine) {
        $this->advertisedLine = $advertisedLine;
    }

    public function getCustomer() {
        return $this->customer;
    }

    public function setCustomer(Customer $customer) {
        $this->customer = $customer;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

}