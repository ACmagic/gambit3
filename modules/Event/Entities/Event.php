<?php namespace Modules\Event\Entities;

use Modules\Core\Entities\User;
use Carbon\Carbon;

class Event {

    protected $id;
    protected $creator;
    protected $displayTitle;
    protected $startsAt;
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

    public function getDisplayTitle() {
        return $this->displayTitle;
    }

    public function setDisplayTitle($displayTitle) {
        $this->displayTitle = $displayTitle;
    }

    public function getStartsAt() {
        return $this->startsAt;
    }

    public function setStartsAt(Carbon $startsAt) {
        $this->startsAt = $startsAt;
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