<?php namespace Modules\Event\Prediction\Resolver;

use Modules\Prediction\PredictableResolver;
use Modules\Event\Repositories\EventRepository;
use Modules\Prediction\Predictable;
use Modules\Event\Entities\Event as EventEntity;
use Doctrine\ORM\QueryBuilder;
use Modules\Prediction\Contracts\Entities\Prediction as PredictionContract;
use Doctrine\ORM\Query\Expr\Orx;
use Doctrine\ORM\Query\Expr\Func as DoctrineFunc;
use Doctrine\DBAL\Types\Type as DbalType;

class EventResolver implements PredictableResolver {

    protected $eventRepo;

    public function __construct(EventRepository $eventRepo) {
        $this->eventRepo = $eventRepo;
    }

    public function getName() {
        return 'event';
    }

    public function getById($id) {
        $event = $this->eventRepo->findById($id);
        return $event;
    }

    public function owns(Predictable $predictable) {
        return $predictable instanceof EventEntity;
    }

    public function pluckId(Predictable $predictable) {
        return $predictable->getId();
    }

    public function applyPredictableFilterToLineQuery(
        QueryBuilder $qb,
        Predictable $predictable,
        Orx $expression,
        int $cursor=0
    ) {

        $jsonContainsArgs = ['l.predictionsCache',':predictionJson'.$cursor.'ValueEvent',':predictionJson'.$cursor.'PathEvent'];
        $jsonContainsFunc = new DoctrineFunc('JSON_CONTAINS',$jsonContainsArgs);
        $expression->add($qb->expr()->eq($jsonContainsFunc,1));
        $qb->setParameter('predictionJson'.$cursor.'ValueEvent',$predictable->getId(),DbalType::BIGINT);
        $qb->setParameter('predictionJson'.$cursor.'PathEvent','$['.$cursor.'].game_id');

    }

}