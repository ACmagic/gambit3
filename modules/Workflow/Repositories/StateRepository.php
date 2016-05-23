<?php namespace Modules\Workflow\Repositories;

interface StateRepository {

    public function findById($id);
    public function findAll();

}