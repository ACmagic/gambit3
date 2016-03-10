<?php namespace Modules\Catalog\Repositories\Doctrine;

use Modules\Catalog\Repositories\AdvertisedLineRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineAdvertisedLineRepository implements AdvertisedLineRepository {

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