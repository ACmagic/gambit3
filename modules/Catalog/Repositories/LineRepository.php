<?php namespace Modules\Catalog\Repositories;

interface LineRepository {

    public function findById($id);
    public function findAll();

}