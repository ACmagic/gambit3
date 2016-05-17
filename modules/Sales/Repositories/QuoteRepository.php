<?php namespace Modules\Sales\Repositories;

interface QuoteRepository {

    public function findById($id);
    public function findAll();
    public function findActiveSessionCart($sessionId,$siteId);

}