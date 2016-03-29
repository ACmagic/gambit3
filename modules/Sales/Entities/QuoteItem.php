<?php namespace Modules\Sales\Entities;

class QuoteItem {

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

}