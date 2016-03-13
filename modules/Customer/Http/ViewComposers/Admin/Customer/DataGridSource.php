<?php namespace Modules\Customer\Http\ViewComposers\Admin\Customer;

use Mesour\DataGrid\Sources\DoctrineGridSource;
use Doctrine\ORM\EntityManagerInterface;
use Modules\Customer\Entities\Customer as CustomerEntity;

class DataGridSource extends DoctrineGridSource {

    public function __construct(EntityManagerInterface $em) {

        $qb = $em->createQueryBuilder();

        $qb
            ->select('c','p','s')
            ->from(CustomerEntity::class, 'c')
            ->join('c.pool','p')
            ->join('p.site','s');

        parent::__construct($qb);

        $this->setPrimaryKey('id');

    }

}