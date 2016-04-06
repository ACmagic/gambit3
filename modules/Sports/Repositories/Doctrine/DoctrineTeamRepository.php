<?php namespace Modules\Sports\Repositories\Doctrine;

use Modules\Sports\Repositories\TeamRepository;
use Modules\Event\Repositories\Doctrine\DoctrineCompetitorRepository;

class DoctrineTeamRepository extends DoctrineCompetitorRepository implements TeamRepository {

    public function findByName($name) {

        return $this->genericRepository->findOneByName($name);

    }

}