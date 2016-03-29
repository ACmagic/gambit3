<?php namespace Modules\Sales\Entities;

use Modules\Core\Entities\Site;
use Modules\Customer\Entities\Customer;
use Doctrine\Common\Collections\ArrayCollection;

class Quote {

    protected $id;
    protected $sessionId;
    protected $site;
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

    public function getSessionId() {
        return $this->sessionId;
    }

    public function setSite(Site $site) {
        $this->site = $site;
    }

    public function getSite() {
        return $this->site;
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