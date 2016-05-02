<?php namespace Modules\Accounting\Entities;

use Carbon\Carbon;

class Posting {

    protected $id;
    protected $account;
    protected $event;
    protected $assetType;
    protected $amount;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function setAccount(Account $account) {
        $this->account = $account;
    }

    public function getAccount() {
        return $this->account;
    }

    public function setEvent(PostingEvent $event) {
        $this->event = $event;
    }

    public function getEvent() {
        return $this->event;
    }

    public function setAssetType(AssetType $assetType) {
        $this->assetType = $assetType;
    }

    public function getAssetType() {
        return $this->assetType;
    }

    public function setAmount($amount) {
       $this->amount = $amount;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function setUpdatedAt(Carbon $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setCreatedAt(Carbon $createdAt) {
        $this->createdAt = $createdAt;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

}