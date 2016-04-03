<?php namespace Modules\Core\Entities;

use LaravelDoctrine\ORM\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Carbon\Carbon;

class User implements AuthenticatableContract {

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

    public function toArray() {

        $data = [
            'id'=> $this->getId(),
            'email'=> $this->getEmail(),
            'createdAt'=> $this->getCreatedAt(),
            'updatedAt'=> $this->getUpdatedAt(),
        ];

        return $data;

    }

}