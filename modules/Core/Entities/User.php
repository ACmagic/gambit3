<?php namespace Modules\Core\Entities;

use LaravelDoctrine\ORM\Auth\Authenticatable;

class User {

    use Authenticatable;

    protected $id;
    protected $email;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
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