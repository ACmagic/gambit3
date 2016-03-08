<?php namespace Modules\Core\Entities;

use Doctrine\Common\Collections\ArrayCollection;

class Site {

    protected $id;
    protected $machineName;
    protected $creator;
    protected $createdAt;
    protected $updatedAt;
    protected $stores;

    public function __construct() {
        $this->stores = new ArrayCollection();
    }

    public function getId() {
    return $this->id;
}

    public function setCreator(User $creator) {
        $this->creator = $creator;
    }

    public function getCreator() {
        return $this->creator;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

}