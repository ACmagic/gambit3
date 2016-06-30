<?php namespace Modules\Catalog\Repositories\Doctrine;

use Modules\Catalog\Repositories\SideRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Modules\Catalog\Entities\Side as SideEntity;

class DoctrineSideRepository implements SideRepository {

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

    public function getSeeker() {
        return $this->genericRepository->findOneByMachineName(SideEntity::SIDE_SEEKER);
    }

    public function getHouse() {
        return $this->genericRepository->findOneByMachineName(SideEntity::SIDE_HOUSE);
    }

}