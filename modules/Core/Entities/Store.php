<?php namespace Modules\Core\Entities;

class Store {

    protected $id;
    protected $site;
    protected $creator;
    protected $createdAt;
    protected $updatedAt;

    public function getId() {
        return $this->id;
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

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

}