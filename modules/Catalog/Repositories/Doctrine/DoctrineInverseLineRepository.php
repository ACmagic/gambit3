<?php namespace Modules\Catalog\Repositories\Doctrine;

use Modules\Catalog\Repositories\InverseLineRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Modules\Prediction\PredictionTypeManager;
use Modules\Core\Facades\Store;
use Modules\Catalog\Repositories\LineWorkflowStateRepository;

class DoctrineInverseLineRepository implements InverseLineRepository {

    protected $genericRepository;
    protected $predictionTypeManager;
    protected $lineWorkflowStateRepo;

    public function __construct(
        ObjectRepository $genericRepository,
        PredictionTypeManager $predictionTypeManager,
        LineWorkflowStateRepository $lineWorkflowStateRepo
    ) {
        $this->genericRepository = $genericRepository;
        $this->predictionTypeManager = $predictionTypeManager;
        $this->lineWorkflowStateRepo = $lineWorkflowStateRepo;
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
        $openState = $this->lineWorkflowStateRepo->findOpenState();

        $qb = $this->genericRepository->createQueryBuilder('l');
        $qb->select('l','s');
        $qb
            ->innerJoin('l.side','s');

        $qb->where('l.store = :store');
        $qb->andWhere('l.state = :state');

        $qb->setParameter('store',$storeId);
        $qb->setParameter('state',$openState);

        $collection = $qb->getQuery()->getResult();
        return $collection;

    }

}