<?php namespace Modules\Sales\Entities;

use Modules\Core\Entities\Store;
use Modules\Customer\Entities\Customer;
use Doctrine\Common\Collections\ArrayCollection;
use Carbon\Carbon;

class Sale {

    protected $id;
    protected $store;
    protected $customer;
    protected $items;
    protected $createdAt;
    protected $updatedAt;

    public function __construct() {
        $this->items = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function setStore(Store $store) {
        $this->store = $store;
    }

    public function getStore() {
        return $this->store;
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

    public function setCreatedAt(Carbon $createdAt) {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setUpdatedAt(Carbon $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function addItem(SaleItem $item) {
        $this->items[] = $item;
    }

}