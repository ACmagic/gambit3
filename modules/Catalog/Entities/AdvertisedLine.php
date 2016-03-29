<?php namespace Modules\Catalog\Entities;

use Modules\Customer\Entities\Customer;

class AdvertisedLine {

    use AdvertisedLineTrait;

    protected $id;
    protected $line;
    protected $customer;
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

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

}