<?php namespace Modules\Workflow\Entities;

use Carbon\Carbon;

abstract class Workflow {

    protected $id;
    protected $humanName;
    protected $machineName;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function getHumanName() {
        return $this->humanName;
    }

    public function setHumanName($humanName) {
        $this->humanName = $humanName;
    }

    public function getMachineName() {
        return $this->machineName;
    }

    public function setMachineName($machineName) {
        $this->machineName = $machineName;
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