<?php namespace Modules\Workflow\Repositories;

interface WorkflowRepository {

    public function findById($id);
    public function findAll();

}