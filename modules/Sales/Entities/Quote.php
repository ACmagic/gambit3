<?php namespace Modules\Sales\Entities;

use Modules\Core\Entities\Site;
use Modules\Customer\Entities\Customer;
use Doctrine\Common\Collections\ArrayCollection;
use Modules\Sales\Entities\QuoteAdvertisedLine;
use Carbon\Carbon;

class Quote {

    protected $id;
    protected $sessionId;
    protected $isCart;
    protected $isExpired;
    protected $site;
    protected $sale;
    protected $customer;
    protected $items;
    protected $createdAt;
    protected $updatedAt;
    protected $expiredAt;

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

    public function getIsCart() {
        return $this->isCart;
    }

    public function setIsCart($isCart) {
        $this->isCart = $isCart;
    }

    public function getIsExpired() {
        return $this->isExpired;
    }

    public function setIsExpired($isExpired) {
        $this->isExpired = $isExpired;
    }

    public function setSite(Site $site) {
        $this->site = $site;
    }

    public function getSite() {
        return $this->site;
    }

    public function setSale(Sale $sale) {
        $this->sale = $sale;
    }

    public function getSale() {
        return $this->sale;
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

    public function getExpiredAt() {
        return $this->expiredAt;
    }

    public function setExpiredAt(Carbon $expiredAt) {
        $this->expiredAt = $expiredAt;
    }

    public function getItems() {
        return $this->items;
    }

    /**
     * Get only the advertised lines in the quote.
     *
     * @return ArrayCollection
     */
    public function getAdvertisedLineItems() {

        $items = new ArrayCollection();

        foreach($this->items as $item) {
            if($item instanceof QuoteAdvertisedLine) {
                $items[] = $item;
            }
        }

        return $items;

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
     * Convert quote to a sale.
     *
     * @return Sale
     */
    public function toSale() {

        $sale = new Sale();
        $sale->setCreatedAt(Carbon::now());
        $sale->setUpdatedAt(Carbon::now());

        foreach($this->items as $item) {

            $saleItem = $item->toSaleItem();
            $saleItem->setSale($sale);

            $sale->addItem($saleItem);

        }

        return $sale;

    }

    /**
     * Quick and dirty to determine whether the quote can be paid for
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