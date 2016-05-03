<?php namespace Modules\Accounting\Repositories\Doctrine;

use Modules\Accounting\Repositories\AccountRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Modules\Accounting\Entities\Account;

class DoctrineAccountRepository implements AccountRepository {

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
     * Calculate the balance of the specified account.
     *
     * @param Account $account
     *   The account.
     *
     * @return double
     */
    public function calculateAccountBalance(Account $account) {

        $qb = $this->genericRepository->createQueryBuilder('a');
        $qb->join('a.postings','p')
            ->where('a = :account')
            ->setParameter('account',$account)
            ->select('SUM(p.amount) as balance');

        $query = $qb->getQuery();
        $balance = $query->getSingleScalarResult();

        return $balance;

    }

}