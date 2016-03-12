<?php namespace Modules\Core\Repositories;

interface UserRepository {

    public function findById($id);
    public function findAll();
    public function createQueryBuilderForAdminDataGrid();

}