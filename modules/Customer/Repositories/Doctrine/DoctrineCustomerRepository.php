<?php namespace Modules\Customer\Repositories\Doctrine;

use Modules\Customer\Repositories\CustomerRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Modules\Core\Facades\Site as SiteFacade;

class DoctrineCustomerRepository implements CustomerRepository {

    protected $genericRepository;

    public function __construct(
        ObjectRepository $genericRepository
    ) {
        $this->genericRepository = $genericRepository;
    }

    public function findById($id) {
        return $this->genericRepository->find($id);
    }

    public function findAll() {
        return $this->genericRepository->findAll();
    }

    public function findInSiteByEmail($email) {

        // Get te current site id.
        $siteId = SiteFacade::getSiteId();

        $qb = $this->genericRepository->createQueryBuilder('c');
        $qb->join('c.pool','p')
            ->where('p.site = :siteId')
            ->andWhere('c.email = :email')
            ->setParameter('siteId',$siteId)
            ->setParameter('email',$email);

        $query = $qb->getQuery();
        $customer = $query->getOneOrNullResult();

        return $customer;

    }

}