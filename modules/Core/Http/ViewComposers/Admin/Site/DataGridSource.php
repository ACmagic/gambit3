<?php namespace Modules\Core\Http\ViewComposers\Admin\Site;

use Mesour\DataGrid\Sources\DoctrineGridSource;
use Doctrine\ORM\EntityManagerInterface;
use Modules\Core\Entities\Site as SiteEntity;

class DataGridSource extends DoctrineGridSource {

    public function __construct(EntityManagerInterface $em) {

        $qb = $em->createQueryBuilder();
        $qb
            ->select('s','c')
            ->from(SiteEntity::class, 's')
            ->join('s.creator','c');

        parent::__construct(SiteEntity::class,'id',$qb);

    }

    final public function getReferencedSource($table, $callback = null, $tablePrefix = '_a0')
    {
        return parent::getReferencedSource(
            $table,
            $callback ? $callback : function () use ($table, $tablePrefix) {
                $tableStructure = $this->getDataStructure()->getTableStructure($table);
                $source = new DoctrineGridSource(
                    $tableStructure->getName(),
                    $tableStructure->getPrimaryKey(),
                    $this->getQueryBuilder()->getEntityManager()
                        ->createQueryBuilder()->select($tablePrefix)
                        ->from($table, $tablePrefix)
                );
                $source->setDataStructure($tableStructure);
                return $source;
            }
        );
    }

}