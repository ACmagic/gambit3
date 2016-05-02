<?php namespace Modules\Sales\Entities;

use Carbon\Carbon;

class QuoteCredit extends QuoteItem {

    protected $amount;

    public function setAmount($amount) {
        $this->amount = $amount;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function calculateCost() {
        return $this->amount;
    }

    public function toSaleItem() {

        $item = new SaleCredit();
        $item->setCreatedAt(Carbon::now());
        $item->setUpdatedAt(Carbon::now());
        $item->setAmount($this->amount);

        return $item;

    }

}