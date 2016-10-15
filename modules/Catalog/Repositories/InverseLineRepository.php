<?php namespace Modules\Catalog\Repositories;

interface InverseLineRepository {

    public function findById($id);
    public function findAll();
    public function findAllStoresAvailableOpenLines() : array;
    public function findAllAvailableWithPredictable($type,$id): array;

}