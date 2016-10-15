<?php namespace Modules\Prediction;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\Expr\Orx;

interface PredictableResolver {

    public function getName();
    public function getById($id);
    public function owns(Predictable $predictable);
    public function pluckId(Predictable $predictable);
    public function applyPredictableFilterToLineQuery(QueryBuilder $qb,Predictable $predictable,Orx $expression,int $cursor=0);

}