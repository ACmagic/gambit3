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
    protected $transactions;
    protected $items;
    protected $createdAt;
    protected $updatedAt;

    public function __construct() {
        $this->items = new ArrayCollection();
        $this->transactions = new ArrayCollection();
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

}