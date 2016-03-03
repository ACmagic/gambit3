<?php namespace Modules\Customer\Entities;

use LaravelDoctrine\ORM\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class Customer implements AuthenticatableContract {

    use Authenticatable;

    protected $id;
    protected $email;
    protected $pool;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function setPool(CustomerPool $pool) {
        $this->pool = $pool;
    }

    public function getPool() {
        return $this->pool;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

}