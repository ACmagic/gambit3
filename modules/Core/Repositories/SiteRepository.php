<?php namespace Modules\Core\Repositories;

interface SiteRepository {

    public function findById($id);
    public function findAll();

}