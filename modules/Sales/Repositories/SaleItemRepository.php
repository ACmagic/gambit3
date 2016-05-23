<?php namespace Modules\Sales\Repositories;

interface SaleItemRepository {

    public function findById($id);
    public function findAll();

}