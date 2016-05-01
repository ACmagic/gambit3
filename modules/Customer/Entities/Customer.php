<?php namespace Modules\Customer\Entities;

use LaravelDoctrine\ORM\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Doctrine\Common\Collections\ArrayCollection;
use Carbon\Carbon;

class Customer implements AuthenticatableContract {

    use Authenticatable;

    protected $id;
    protected $email;
    protected $pool;
    protected $accounts;
    protected $createdAt;
    protected $updatedAt;

    public function __construct() {
        $this->accounts = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function setPool(CustomerPool $pool) {
        $this->pool = $pool;
    }

    public function getPool() {
        return $this->pool;
    }

    public function getInternalAccount() {

    }

    public function getExternalAccount() {

    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
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

}