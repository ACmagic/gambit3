<?php namespace Modules\Core\Http\ViewComposers\Admin\User;

use Mesour\DataGrid\Sources\DoctrineGridSource;
use Doctrine\ORM\EntityManagerInterface;
use Modules\Core\Entities\User as UserEntity;

class DataGridSource extends DoctrineGridSource {

    public function __construct(EntityManagerInterface $em) {

        $qb = $em->createQueryBuilder();

        $qb
            ->select('u')
            ->from(UserEntity::class, 'u');

        parent::__construct($qb);
        $this->setPrimaryKey('id');

    }

}