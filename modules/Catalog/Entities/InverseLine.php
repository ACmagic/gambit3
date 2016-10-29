<?php namespace Modules\Catalog\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Modules\Catalog\Contracts\Entities\Line as LineContract;
use Modules\Catalog\Repositories\SideRepository;

class InverseLine implements LineContract {

    use LineTrait;

    public function __construct() {
        $this->advertisedLines = new ArrayCollection();
        $this->predictions = new ArrayCollection();
        $this->transitions = new ArrayCollection();
    }

    public function getSide() {

        $sideRepo = app(SideRepository::class);

        if($this->side->getId() === $sideRepo->getSeeker()->getId()) {
            $side = $sideRepo->getHouse();
        } else {
            $side = $sideRepo->getSeeker();
        }

        return $side;

    }

}