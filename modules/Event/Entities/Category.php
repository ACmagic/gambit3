<?php namespace Modules\Event\Entities;

use Modules\Core\Entities\User;
use Carbon\Carbon;
use Doctrine\Common\Collections\ArrayCollection;

class Category {

    protected $id;
    protected $creator;
    protected $lft;
    protected $rgt;
    protected $lvl;
    protected $humanName;
    protected $machineName;
    protected $updatedAt;
    protected $createdAt;
    protected $root;
    protected $parent;
    protected $children;

    protected $events;

    public function __construct() {
        $this->events = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getCreator() {
        return $this->creator;
    }

    public function setCreator(User $creator) {
        $this->creator = $creator;
    }

    public function getRoot() {
        return $this->root;
    }

    public function setParent(Category $parent=null) {
        $this->parent = $parent;
    }

    public function getParent() {
        return $this->parent;
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