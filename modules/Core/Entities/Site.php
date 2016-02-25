<?php namespace Modules\Core\Entities;

class Site {

    protected $id;
    protected $creator;
    protected $createdAt;
    protected $updatedAt;

    public function setCreator(User $creator) {
        $this->creator = $creator;
    }

    public function getCreator() {
        return $this->creator;
    }

}