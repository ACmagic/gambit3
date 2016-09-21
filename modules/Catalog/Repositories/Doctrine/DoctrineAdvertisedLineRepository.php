<?php namespace Modules\Catalog\Repositories\Doctrine;

use Modules\Catalog\Repositories\AdvertisedLineRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Modules\Catalog\Contracts\Entities\Line as LineContract;
use Modules\Catalog\Entities\AdvertisedLine;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineAdvertisedLineRepository implements AdvertisedLineRepository {

    protected $genericRepository;
    protected $em;

    public function __construct(
        EntityManagerInterface $em,
        ObjectRepository $genericRepository
    ) {
        $this->em = $em;
        $this->genericRepository = $genericRepository;
    }

    public function findById($id) {
        return $this->genericRepository->find($id);
    }

    public function findAll() {
        return $this->genericRepository->findAll();
    }

    /**
     * Find the first available advertised line.
     *
     * @throws \Exception
     *
     * @param LineContract $line
     *   The line.
     *
     * @param float $amount
     *   The amount.
     *
     * @param int $quantity
     *   The quantity.
     *
     * @return array
     *   The matched line.
     *
     */
    public function matchAvailable(LineContract $line,$amount,$quantity) {

        $matched = [];

        /*
 * One of the limitations of DQL is joining
 * against sub-queries. Therefore, a native query
 * must be used instead of DQL.
 */
        $rsm = new ResultSetMappingBuilder($this->em);
        $rsm->addRootEntityFromClassMetadata(AdvertisedLine::class, 'a');
        $selectClause = $rsm->generateSelectClause(['a'=>'ad']);

        $sql = <<<EOD
SELECT
     $selectClause
  FROM
     advertised_lines ad
 INNER
  JOIN
    (SELECT
         ad.id advertised_line_id,
         ad.amount,
         ad.amount_max,
         ad.inventory - SUM(COALESCE(ac.quantity,0)) realtime_inventory
      FROM
         advertised_lines ad
      LEFT OUTER
      JOIN
         accepted_lines ac
        ON
          ad.id = ac.advertised_line_id
     WHERE
          ad.line_id = :lineId
     GROUP
        BY
         ad.id,
         ad.amount,
         ad.amount_max
    HAVING
         realtime_inventory > 0
      AND
         :amount BETWEEN ad.amount AND COALESCE(ad.amount_max,ad.amount)) av
   ON
      ad.id = av.advertised_line_id
EOD;

        $query = $this->em->createNativeQuery($sql, $rsm);
        $query->setParameter('lineId', $line->getId());
        $query->setParameter('amount',$amount);

        // This could possibly be a gigantic result set so iterate one by one.
        $iterator = $query->iterate();
        $desiredQuantity = $quantity;

        foreach($iterator as $item) {

            $advertisedLine = $item[0];

            $matched[] = $advertisedLine;
            $desiredQuantity -= $advertisedLine->getInventory();

            if($desiredQuantity < 1) {
                break;
            }

        }

        if($desiredQuantity > 0) {
            throw new \Exception('Requested amount of advertised lines not available.');
        }

        return $matched;

    }

}