<?php namespace Modules\Catalog\Entities;

use Carbon\Carbon;

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

    public function setMachineName($machineName) {
        $this->machineName = $machineName;
    }

    public function getHumanName() {
        return $this->humanName;
    }

    public function setHumanName($humanName) {
        $this->humanName = $humanName;
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