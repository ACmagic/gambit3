<?php namespace Modules\Catalog\Entities;

use Modules\Core\Entities\Store;
use Doctrine\Common\Collections\ArrayCollection;

class Line {

    protected $id;
    protected $store;
    protected $side;
    protected $odds;
    protected $createdAt;
    protected $updatedAt;
    protected $advertisedLines;

    public function __construct() {
        $this->advertisedLines = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function setStore(Store $store) {
        $this->store = $store;
    }

    public function getStore() {
        return $this->store;
    }

    public function setSide(Side $side) {
        $this->side = $side;
    }

    public function getSide() {
        return $this->side;
    }

    public function getOdds() {
        return $this->odds;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

}