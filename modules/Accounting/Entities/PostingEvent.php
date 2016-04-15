<?php namespace Modules\Accounting\Entities;

use Carbon\Carbon;

class PostingEvent {

    protected $id;
    protected $machineName;
    protected $humanName;
    protected $updatedAt;
    protected $createdAt;

    public function getId() {
        return $this->id;
    }

    public function setMachineName($machineName) {
        $this->machineName = $machineName;
    }

    public function getMachineName() {
        return $this->machineName;
    }

    public function setHumanName($humanName) {
        $this->humanName = $humanName;
    }

    public function getHumanName() {
        return $this->humanName;
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