<?php namespace Modules\Core\Mesour\DataGrid\Sources;

use Mesour\DataGrid\Sources\DoctrineGridSource as BaseDoctrineGridSource;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NoResultException;

class DoctrineGridSource extends BaseDoctrineGridSource {

    public function getReferencedSource($table, $callback = null, $tablePrefix = '_a0')
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

    public function fetchAll()
    {
        try {
            $this->lastFetchAllResult = $this->getQuery()->getResult(AbstractQuery::HYDRATE_ARRAY);
            return $this->lastFetchAllResult;

           /*return $this->fixResult(
                $this->getEntityArrayAsArrays($this->lastFetchAllResult)
            );*/
        } catch (NoResultException $e) {
            return [];
        }
    }

    public function fetchFullData($dateFormat = 'Y-m-d') {
        try {
            $allData = $this->lastFetchAllResult = $this->cloneQueryBuilder(true)
                ->setMaxResults(null)
                ->setFirstResult(null)
                ->getQuery()
                ->getResult(AbstractQuery::HYDRATE_ARRAY);

            /*$allData = $this->fixResult(
                $this->getEntityArrayAsArrays($this->lastFetchAllResult)
            );*/

            foreach ($allData as &$currentData) {
                foreach ($currentData as $key => $val) {
                    if ($val instanceof \DateTime) {
                        $currentData[$key] = $val->format($dateFormat);
                    }
                }
            }
            return $allData;
        } catch (NoResultException $e) {
            return [];
        }
    }

}