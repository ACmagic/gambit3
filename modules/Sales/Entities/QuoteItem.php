<?php namespace Modules\Sales\Entities;

use Carbon\Carbon;

abstract class QuoteItem {

    protected $id;
    protected $quote;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function setQuote(Quote $quote) {
        $this->quote = $quote;
    }

    public function getQuote() {
        return $this->quote;
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

    /**
     * Calculate the cost of this line item.
     *
     * @return double
     */
    abstract public function calculateCost();

    /**
     * Convert to a sale item.
     *
     * @return SaleItem
     */
    abstract public function toSaleItem();

    /**
     * Determine whether item can be paid for via credits.
     *
     * @return bool
     */
    abstract public function isPayableViaCredits();

}