<?php namespace Modules\Accounting\Entities;

use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;

class Account {

    protected $id;
    protected $type;
    protected $balance;
    protected $postings;
    protected $createdAt;
    protected $updatedAt;

    public function __construct() {
        $this->postings = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function setType(AccountType $type) {
        $this->type = $type;
    }

    public function getType() {
        return $this->type;
    }

    public function setBalance($balance) {
        $this->balance = $balance;
    }

    public function getBalance() {
        return $this->balance;
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