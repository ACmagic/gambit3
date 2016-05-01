<?php namespace Modules\Sales\Entities;

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

}