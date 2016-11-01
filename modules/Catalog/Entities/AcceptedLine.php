<?php namespace Modules\Catalog\Entities;

use Carbon\Carbon;
use Modules\Customer\Entities\Customer;
use Doctrine\Common\Collections\ArrayCollection;

class AcceptedLine {

    use AcceptedLineTrait;

    protected $id;
    protected $customer;
    protected $createdAt;
    protected $updatedAt;

    protected $payouts;

    public function __construct() {
        $this->payouts = new ArrayCollection();
    }

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

    public function setCreatedAt(Carbon $createdAt) {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(Carbon $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

}