<?php namespace Modules\Sports\Entities;

use Modules\Event\Entities\Competitor;

class Team extends Competitor {

    protected $name;

    public function getName() {
        return $this->name;
    }

}