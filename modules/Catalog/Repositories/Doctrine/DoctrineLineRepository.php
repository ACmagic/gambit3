<?php namespace Modules\Catalog\Repositories\Doctrine;

use Modules\Catalog\Repositories\LineRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Modules\Catalog\Entities\Line as LineEntity;
use Modules\Prediction\PredictionTypeManager;

class DoctrineLineRepository implements LineRepository {

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

    public function createQueryBuilderForAdminDataGrid() {

        $qb = $this->genericRepository->createQueryBuilder('l');
        $qb->select('l','s');
        $qb
            ->join('l.store','s');

        return $qb;

    }

    /**
     * Match open line against another line. This is a potentially
     * long running process. Therefore, it should only be called
     * from the command line such as; through a job.
     *
     * @param LineEntity $line
     *   The line to match.
     *
     * @return LineEntity
     */
    public function matchOpenLine(LineEntity $line) : LineEntity {

        $store = $line->getStore();
        $side = $line->getSide();
        $odds = $line->getOdds();

        $qb = $this->genericRepository->createQueryBuilder('l');
        $qb->select('l');
        $qb->where('l.store = :store');
        $qb->andWhere('l.side = :side');
        $qb->andWhere('l.odds = :odds');
        $qb->setParameter('store',$store);
        $qb->setParameter('side',$side);
        $qb->setParameter('odds',$odds);

        $i=0;
        $line
        $count = count($predictions);
        
        foreach($line->getPredictions() as $prediction) {
            
            $type = $this->predictionTypeManager->getTypeByEntity($prediction);
            $type->requirePredictionWithLine($qb,$prediction,$i);

            break;
            
        }

        $query = $qb->getQuery();
        $matchedLines = $query->execute()->fetchAll();

        if(count($matchedLines) <= 1) {
            return $matchedLines;
        }

        // @todo: Attempt to match single line.
        foreach($matchedLines as $matchedLine) {

        }

    }

}