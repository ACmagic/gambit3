<?php namespace Modules\Customer\Entities;

use Modules\Core\Entities\Site;
use Doctrine\Common\Collections\ArrayCollection;

class CustomerPool {

    protected $id;
    protected $site;
    protected $customers;
    protected $createdAt;
    protected $updatedAt;

    public function __construct() {
        $this->customers = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function setSite(Site $site) {
        $this->site = $site;
    }

    public function getSite() {
        return $this->site;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

}