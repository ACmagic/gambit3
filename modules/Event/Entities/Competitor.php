<?php namespace Modules\Event\Entities;

use Modules\Core\Entities\User;
use Carbon\Carbon;

class Competitor {

    protected $id;
    protected $creator;
    protected $createdAt;
    protected $updatedAt;

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