<?php namespace Modules\Sales\Entities;

use Modules\Core\Entities\Site;
use Modules\Customer\Entities\Customer;
use Doctrine\Common\Collections\ArrayCollection;
use Carbon\Carbon;

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

    public function setSessionId($sessionId) {
        $this->sessionId = $sessionId;
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

    public function setCreatedAt(Carbon $createdAt) {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setUpdatedAt(Carbon $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function addItem(QuoteItem $item) {
        $this->items[] = $item;
    }

    /**
     * Get the first advertised line item.
     */
    public function getFirstAdvertisedLineItem() {

        $target = NULL;

        foreach($this->items as $item) {
            if($item instanceof QuoteAdvertisedLine) {
                $target = $item;
                break;
            }
        }

        return $target;

    }

}