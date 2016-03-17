<?php namespace Modules\Event\Repositories;

interface CompetitorRepository {

    public function findById($id);
    public function findAll();

}