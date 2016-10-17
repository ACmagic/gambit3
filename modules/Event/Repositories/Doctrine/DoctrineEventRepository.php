<?php namespace Modules\Event\Repositories\Doctrine;

use Modules\Event\Repositories\EventRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Modules\Event\Entities\EventWorkflowState;

class DoctrineEventRepository implements EventRepository {

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

    public function findAllByType($type) {

        $qb = $this->genericRepository->createQueryBuilder('e')
            ->where('e INSTANCE OF '.$type);

        $query = $qb->getQuery();
        $events = $query->getResult();

        return $events;

    }

    public function findOpenEventsByCategory($categoryId) {

        $qb = $this->genericRepository->createQueryBuilder('e');
        $qb->innerJoin('e.state','s');
        $qb->innerJoin('e.categories','c');
        $qb->where('s.machineName = :openState');
        $qb->andWhere('c = :categoryId');

        $qb->setParameter('openState',EventWorkflowState::STATE_OPEN);
        $qb->setParameter('categoryId',$categoryId);

        $query = $qb->getQuery();
        $events = $query->getResult();

        return $events;

    }

}