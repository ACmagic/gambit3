<?php namespace Modules\Customer\Repositories;

interface CustomerRepository {

    public function findById($id);
    public function findAll();

}