<?php namespace Modules\Catalog\Entities;

use Carbon\Carbon;
use Modules\Customer\Entities\Customer;
use Doctrine\Common\Collections\ArrayCollection;

class AdvertisedLine {

    use AdvertisedLineTrait;

    protected $id;
    protected $line;
    protected $customer;
    protected $createdAt;
    protected $updatedAt;

    protected $payouts;

    public function __construct() {
        $this->acceptedLines = new ArrayCollection();
        $this->payouts = new ArrayCollection();
    }

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