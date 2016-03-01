<?php namespace Modules\Core\Repositories;

interface StoreRepository {

    public function findById($id);
    public function findAll();

}