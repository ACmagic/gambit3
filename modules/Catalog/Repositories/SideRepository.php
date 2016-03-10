<?php namespace Modules\Catalog\Repositories;

interface SideRepository {

    public function findById($id);
    public function findAll();

}