<?php namespace Modules\Catalog\Entities;

class Side {

    protected $id;
    protected $machineName;
    protected $humanName;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function getMachineName() {
        return $this->machineName;
    }

    public function getHumanName() {
        return $this->humanName;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

}