<?php namespace Modules\Catalog\Entities;

use Modules\Customer\Entities\Customer;

class AcceptedLine {

    use AcceptedLineTrait;

    protected $id;
    protected $customer;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
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