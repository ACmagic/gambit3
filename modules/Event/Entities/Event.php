<?php namespace Modules\Event\Entities;

use Modules\Core\Entities\User;

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

    public function getStartsAt() {
        return $this->startsAt;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

}