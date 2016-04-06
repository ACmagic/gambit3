<?php namespace Modules\Sports\Repositories;

use Modules\Event\Repositories\CompetitorRepository;

interface TeamRepository extends CompetitorRepository {

    /**
     * Find single team by name.
     *
     * @param string $name
     *   The name.
     *
     * @return
     */
    public function findByName($name);

}