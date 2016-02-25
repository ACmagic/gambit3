<?php namespace Modules\Core\Entities;

use LaravelDoctrine\ORM\Auth\Authenticatable;

class User {

    use Authenticatable;

    protected $id;
    protected $email;
    protected $createdAt;
    protected $updatedAt;

    public function getEmail() {
        return $this->email;
    }

}