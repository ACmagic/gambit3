<?php namespace Modules\Sales\Repositories\Doctrine;

use Modules\Sales\Repositories\SaleItemRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineSaleItemRepository implements SaleItemRepository {

    protected $genericRepository;

    public function __construct(ObjectRepository $genericRepository) {
        $this->genericRepository = $genericRepository;
    }

    public function findById($id) {
        return $this->genericRepository->find($id);
    }

    public function findAll() {
        return $this->genericRepository->findAll();
    }

}