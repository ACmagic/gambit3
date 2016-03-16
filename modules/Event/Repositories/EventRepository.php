<?php namespace Modules\Event\Repositories;

interface EventRepository {

    public function findById($id);
    public function findAll();

}