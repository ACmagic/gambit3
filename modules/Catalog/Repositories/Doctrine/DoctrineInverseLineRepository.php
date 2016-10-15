<?php namespace Modules\Catalog\Repositories\Doctrine;

use Modules\Catalog\Repositories\InverseLineRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Modules\Prediction\PredictionTypeManager;
use Modules\Core\Facades\Store;
use Modules\Catalog\Repositories\LineWorkflowStateRepository;
use Modules\Prediction\Contracts\PredictableManager as IPredictableManager;
use Modules\Prediction\Contracts\PredictionTypeManager as IPredictionTypeManager;

class DoctrineInverseLineRepository implements InverseLineRepository {

    protected $genericRepository;
    protected $predictionTypeManager;
    protected $lineWorkflowStateRepo;
    protected $predictableManager;
    protected $predictableTypeManager;

    public function __construct(
        ObjectRepository $genericRepository,
        PredictionTypeManager $predictionTypeManager,
        LineWorkflowStateRepository $lineWorkflowStateRepo,
        IPredictableManager $predictableManager,
        IPredictionTypeManager $predictableTypeManager
    ) {
        $this->genericRepository = $genericRepository;
        $this->predictionTypeManager = $predictionTypeManager;
        $this->lineWorkflowStateRepo = $lineWorkflowStateRepo;
        $this->predictableManager = $predictableManager;
        $this->predictableTypeManager = $predictableTypeManager;
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
    public function findAllStoresAvailableOpenLines() : array {

        $storeId = Store::getStoreId();
        $openState = $this->lineWorkflowStateRepo->findOpenState();

        $qb = $this->genericRepository->createQueryBuilder('l');
        $qb->select('l','s');
        $qb
            ->innerJoin('l.side','s');

        $qb->where('l.store = :store');
        $qb->andWhere('l.state = :state');
        $qb->andWhere('l.realTimeInventory > 0');

        $qb->setParameter('store',$storeId);
        $qb->setParameter('state',$openState);

        $collection = $qb->getQuery()->getResult();
        return $collection;

    }

    /**
     * Find all lines associated with the specified predictable.
     *
     * @param string $type
     *   The predictable type.
     *
     * @param int $id
     *   The predictable type id.
     *
     * @return array
     */
    public function findAllAvailableWithPredictable($type,$id) : array {

        $predictableResolver = $this->predictableManager->getResolver($type);
        $event = $predictableResolver->getById($id);
        $types = $this->predictableTypeManager->getTypes($event);
        $compatiblePredictionClasses = [];

        foreach($types as $type) {
            $compatiblePredictionClasses[] = $type->getInverseEntityClassName();
        }

        $openState = $this->lineWorkflowStateRepo->findOpenState();

        $qb = $this->genericRepository->createQueryBuilder('l');
        $qb->select('l','s');
        $qb
            ->innerJoin('l.side','s')
            // @todo: It would be nice to filter by the discriminator column without requiring all the extra child table joins?
            ->innerJoin('l.predictions','p','WITH','p INSTANCE OF :compatiblePredictionClasses');

        $qb->andWhere('l.state = :state');
        $qb->andWhere('l.realTimeInventory > 0');
        //$qb->andWhere('l.inverse_type IN (:compatiblePredictionClasses)');

        $qb->setParameter('state',$openState);
        $qb->setParameter('compatiblePredictionClasses',$compatiblePredictionClasses);

        /*
         * Unfortunately Syslogic json functions aren't compatible with ->. Therrefore,
         * the below work-around is used generous assumption that no line will
         * have more than 10 predictions associated with it.
         */
        $jsonExpressionMatcher = $qb->expr()->orX();

        for($i=0;$i<10;$i++) {
            $predictableResolver->applyPredictableFilterToLineQuery($qb,$event,$jsonExpressionMatcher,$i);
        }

        $qb->andWhere($jsonExpressionMatcher);

        $collection = $qb->getQuery()->getResult();
        return $collection;

    }

}