<?php namespace Modules\Core\Entities;

use Carbon\Carbon;

class Store {

    protected $id;
    protected $site;
    protected $machineName;
    protected $creator;
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

    public function setSite(Site $site) {
        $this->site = $site;
    }

    public function getSite() {
        return $this->site;
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

    public function toArray() {

        $data = [
            'id'=> $this->getId(),
            'machineName'=> $this->getMachineName(),
            'createdAt'=> $this->getCreatedAt(),
            'updatedAt'=> $this->getUpdatedAt(),
        ];

        return $data;

    }

}