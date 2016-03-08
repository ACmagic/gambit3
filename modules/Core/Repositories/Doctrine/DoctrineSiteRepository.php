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

    public function findAll() {
        return $this->genericRepository->findAll();
    }

    public function findByMachineName($machineName) {
        return $this->genericRepository->findOneByMachineName($machineName);
    }

    public function findByStoreId($storeId) {

        $qb = $this->genericRepository->createQueryBuilder('s');
        $qb->join('s.stores','st')
            ->where('st.id = :storeId')
            ->setParameter('storeId',$storeId);

        $query = $qb->getQuery();
        $site = $query->getOneOrNullResult();

        return $site;

    }

}