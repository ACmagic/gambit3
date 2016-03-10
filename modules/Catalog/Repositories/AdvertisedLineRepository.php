<?php namespace Modules\Catalog\Repositories;

interface AdvertisedLineRepository {

    public function findById($id);
    public function findAll();

}