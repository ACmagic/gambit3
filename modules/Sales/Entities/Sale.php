<?php namespace Modules\Sales\Entities;

use Modules\Core\Entities\Store;
use Modules\Customer\Entities\Customer;
use Doctrine\Common\Collections\ArrayCollection;
use Modules\Accounting\Entities\Posting as PostingEntity;
use Carbon\Carbon;

class Sale {

    protected $id;
    protected $store;
    protected $customer;
    protected $state;
    protected $transactions;
    protected $transitions;
    protected $items;
    protected $createdAt;
    protected $updatedAt;

    public function __construct() {
        $this->items = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->transitions = new ArrayCollection();
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

    public function getState() {
        return $this->state;
    }

    public function setState(SaleWorkflowState $state) {
        $this->state = $state;
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

    public function addTransition(SaleWorkflowTransition $transition) {
        $this->transitions[] = $transition;
    }

    public function getItems() {
        return $this->items;
    }

    /**
     * Add new sales transaction.
     *
     * @param PostingEntity $posting
     *   The account posting.
     */
    public function addTransaction(PostingEntity $posting) {
        $this->transactions[] = $posting;
    }

    /**
     * Calculate the total cost of items.
     *
     * @return double
     */
    public function calculateTotalCost() {

        $total = 0;

        foreach($this->items as $item) {
            $total = bcadd($total,$item->calculateCost(),4);
        }

        return $total;

    }

    /**
     * Quick and dirty to determine whether the sale can be paid for
     * via credits.
     */
    public function isPayableViaCredits() {

        foreach($this->items as $item) {
            if(!$item->isPayableViaCredits()) {
                return false;
            }
        }

        return true;

    }

    /**
     * Detect sale with an advertised line.
     *
     * @return bool
     */
    public function hasAdvertisedLine() {

        foreach($this->items as $item) {
            if($item instanceof SaleAdvertisedLine) {
                return true;
            }
        }

        return false;

    }

    /**
     * Detect sale with an accepted line.
     *
     * @return bool
     */
    public function hasAcceptedLine() {

        foreach($this->items as $item) {
            if($item instanceof SaleAcceptedLine) {
                return true;
            }
        }

        return false;

    }

}