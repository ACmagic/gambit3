<?php namespace Modules\Catalog\Repositories;

interface AcceptedLineRepository {

    public function findById($id);
    public function findAll();

}