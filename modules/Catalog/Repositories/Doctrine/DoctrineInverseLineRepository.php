<?php namespace Modules\Catalog\Repositories\Doctrine;

use Modules\Catalog\Repositories\InverseLineRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Modules\Prediction\PredictionTypeManager;
use Modules\Core\Facades\Store;

class DoctrineInverseLineRepository implements InverseLineRepository {

    protected $genericRepository;
    protected $predictionTypeManager;

    public function __construct(
        ObjectRepository $genericRepository,
        PredictionTypeManager $predictionTypeManager
    ) {
        $this->genericRepository = $genericRepository;
        $this->predictionTypeManager = $predictionTypeManager;
    }

    public function findById($id) {
        return $this->genericRepository->find($id);
    }

    public function findAll() {
        return $this->genericRepository->findAll();
    }

    /**
     * Find all the open lines in store.
     */
    public function findAllStoresOpenLines() : array {

        $storeId = Store::getStoreId();

        $qb = $this->genericRepository->createQueryBuilder('l');
        $qb->select('l','s');
        $qb
            ->innerJoin('l.side','s');

        $qb->where('l.store = :store');

        $qb->setParameter('store',$storeId);

        $collection = $qb->getQuery()->getResult();
        return $collection;

    }

}