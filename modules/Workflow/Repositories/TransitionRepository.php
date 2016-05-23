<?php namespace Modules\Workflow\Repositories;

interface TransitionRepository {

    public function findById($id);
    public function findAll();

}