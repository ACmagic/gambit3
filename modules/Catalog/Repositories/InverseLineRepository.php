<?php namespace Modules\Catalog\Repositories;

interface InverseLineRepository {

    public function findById($id);
    public function findAll();
    public function findAllStoresOpenLines() : array;

}