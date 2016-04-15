<?php namespace Modules\Core\Http\ViewComposers\Admin\Site;

use Modules\Core\Entities\Site as SiteEntity;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Core\Mesour\DataGrid\Sources\DoctrineGridSource;

class DataGridSource extends DoctrineGridSource {

    public function __construct() {

        $qb = EntityManager::createQueryBuilder();
        $qb
            ->select('s','c')
            ->from(SiteEntity::class, 's')
            ->join('s.creator','c');

        parent::__construct(SiteEntity::class,'id',$qb);

    }

}