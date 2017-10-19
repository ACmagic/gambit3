<?php namespace Modules\Catalog\Repositories\Doctrine;

use Modules\Catalog\Repositories\AcceptedLineRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Modules\Catalog\Entities\AcceptedLine;

class DoctrineAcceptedLineRepository implements AcceptedLineRepository {

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

    /**
     * Calculate sum of amounts for all accepted lines belonging
     * to the passed advertised line id.
     *
     * @param int $advertisedLineId
     *   The advertiesed line id.
     *
     * @return int
     */
    public function sumTotalAmountByAdvertisedLineId(int $advertisedLineId): int {

        $qb = $this->genericRepository->createQueryBuilder('a');
        $qb->resetDQLParts();

        $qb->select('SUM(a.amount * a.quantity) as total')->from(AcceptedLine::class,'a');
        $qb->where('a.advertisedLine = :advertisedLine');
        $qb->setParameter('advertisedLine',$advertisedLineId);

        $query = $qb->getQuery();
        $value = $query->getSingleScalarResult();

        return (int) $value;

    }

}