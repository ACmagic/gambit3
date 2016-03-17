<?php namespace Modules\Sports\Entities;

use Modules\Event\Entities\Competitor;

class Player extends Competitor {

    protected $firstName;
    protected $lastName;
    protected $middleName;

    public function getFirstName() {
        return $this->firstName;
    }

    public function getLastName() {
        return $this->lastName;
    }

    public function getMiddleName() {
        return $this->middleName;
    }

}