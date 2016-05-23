<?php namespace Modules\Workflow\Entities;

use Carbon\Carbon;

abstract class Transition {

    protected $id;
    protected $beforeState;
    protected $afterState;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
    }

    public function getBeforeState() {
        return $this->beforeState;
    }

    public function setBeforeState(State $beforeState) {
        $this->beforeState = $beforeState;
    }

    public function getAfterState() {
        return $this->afterState;
    }

    public function setAfterState(State $afterState) {
        $this->afterState = $afterState;
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