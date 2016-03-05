<?php namespace Modules\Customer\Repositories;

interface CustomerPoolRepository {

    public function findById($id);
    public function findAll();
    public function findBySiteId($siteId);

}