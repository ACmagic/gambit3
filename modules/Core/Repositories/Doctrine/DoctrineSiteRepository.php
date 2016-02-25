<?php namespace Modules\Core\Repositories\Doctrine;

use Modules\Core\Repositories\SiteRepository;
use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineSiteRepository implements SiteRepository {

    protected $genericRepository;

    public function __construct(ObjectRepository $genericRepository) {
        $this->genericRepository = $genericRepository;
    }

    public function findById($id) {
        return $this->genericRepository->find($id);
    }

}