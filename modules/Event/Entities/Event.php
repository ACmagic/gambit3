<?php namespace Modules\Event\Entities;

use Modules\Core\Entities\User;
use Carbon\Carbon;
use Modules\Prediction\Predictable;
use Doctrine\Common\Collections\ArrayCollection;
use Modules\Event\Repositories\EventWorkflowStateRepository;

class Event implements Predictable {

    protected $id;
    protected $creator;
    protected $state;
    protected $displayTitle;
    protected $startsAt;
    protected $createdAt;
    protected $updatedAt;

    protected $categories;

    public function __construct() {
        $this->categories = new ArrayCollection();
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

    public function getState() {
        return $this->state;
    }

    public function setState(EventWorkflowState $state) {
        $this->state = $state;
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

    public function isPredictionAllowed(): bool {
        return $this->getState()->getMachineName() == EventWorkflowState::STATE_OPEN;
    }

}