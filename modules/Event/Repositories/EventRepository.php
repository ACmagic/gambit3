<?php namespace Modules\Event\Repositories;

interface EventRepository {

    public function findById($id);
    public function findAll();
    public function findAllByType($type);
    public function buildQueryOpenEventsByCategory($categoryId);
    public function findOpenEventsByCategory($categoryId);

}