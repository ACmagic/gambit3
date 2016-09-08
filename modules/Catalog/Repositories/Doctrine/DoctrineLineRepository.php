<?php namespace Modules\Catalog\Repositories\Doctrine;

use Modules\Catalog\Repositories\LineRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Modules\Catalog\Entities\Line as LineEntity;
use Modules\Prediction\PredictionTypeManager;
use Doctrine\ORM\Query\Expr\Func as DoctrineFunc;

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
     * Can't use LineEntity as return type because only 7.1+
     * supports nullable return types ie. : ?LineEntity
     *
     * @param LineEntity $line
     *   The line to match.
     *
     * @return ?LineEntity
     */
    public function matchOpenLine(LineEntity $line) {

        $store = $line->getStore();
        $side = $line->getSide();
        $odds = $line->getOdds();

        $predictionCount = $line->getPredictions()->count();

        $qb = $this->genericRepository->createQueryBuilder('l');

        $qb->select('l');
        $qb->innerJoin('l.predictions','p');
        $qb->where('l.store = :store');
        $qb->andWhere('l.side = :side');
        $qb->andWhere('l.odds = :odds');
        $qb->addGroupBy('l.id');

        /*
         * This guarantees that the line returned has ALL predictions and no
         * more or no less.
         */
        $havingExpr = $qb->expr()->eq($qb->expr()->count('p.id'), ':predictionCount');
        $qb->having($havingExpr);

        /*
         * This trickery allows use to match a line with the same predictions
         * as the line provided without a bunch of complex, convoluted and
         * inefficient join logic. Without the predictions_cache and
         * json_contains this becomes a nightmare both in of terms of
         * simplicity and efficiency.
         */
        foreach($line->getPredictions() as $index=>$prediction) {

            $json = json_encode($prediction);
            $jsonExpressionMatcher = $qb->expr()->orX();

            // Syslogic json functions aren't compatible with ->. Therefore, the below work around is used.
            //$contains = 'JSON_CONTAINS(l.predictions_cache->\'$[*]\',:predictionJson'.$index.')';

            //$jsonContainsArgs = ["l.predictionsCache->'$[*]'",':predictionJson'.$index];
            //$jsonContainsFunc = new DoctrineFunc('JSON_CONTAINS',$jsonContainsArgs);

            //$qb->andWhere($jsonContainsFunc);
            //$qb->setParameter('predictionJson'.$index,$json);

            for($i=0;$i<$predictionCount;$i++) {
                //$contains = 'JSON_CONTAINS(l.predictions_cache,:predictionJson'.$index.'Value'.$i.',:predictionJson'.$index.'Path'.$i.')';
                $jsonContainsArgs = ['l.predictionsCache',':predictionJson'.$index.'Value'.$i,':predictionJson'.$index.'Path'.$i];
                $jsonContainsFunc = new DoctrineFunc('JSON_CONTAINS',$jsonContainsArgs);
                $jsonExpressionMatcher->add($qb->expr()->eq($jsonContainsFunc,1));
                $qb->setParameter('predictionJson'.$index.'Value'.$i,$json);
                $qb->setParameter('predictionJson'.$index.'Path'.$i,'$['.$i.']');
            }

            $qb->andWhere($jsonExpressionMatcher);

        }

        $qb->setParameter('store',$store);
        $qb->setParameter('side',$side);
        $qb->setParameter('odds',$odds);
        $qb->setParameter('predictionCount',$predictionCount);

        /**
         * I don't believe any of this is necessary anymore. I think we just
         * need to require/join all the predictions associated with the line.\
         * Leaving this here for reference. Although I'm really not certain of the
         * necessity of requirePredictionWithLine either. I guess
         * it is a good utility to have for prediction plugins.
         */
        /*foreach($line->getPredictions() as $index=>$prediction) {
            
            $type = $this->predictionTypeManager->getTypeByEntity($prediction);
            $type->requirePredictionWithLine($qb,$prediction,$index);

            break;
            
        }*/

        $query = $qb->getQuery();
        $matchedLine = $query->getOneOrNullResult();

        return $matchedLine;

    }

}