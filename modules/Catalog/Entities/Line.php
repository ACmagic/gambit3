<?php namespace Modules\Catalog\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Modules\Catalog\Contracts\Entities\Line as LineContract;

class Line implements LineContract {

    use LineTrait;

    public function __construct() {
        $this->advertisedLines = new ArrayCollection();
        $this->predictions = new ArrayCollection();
        $this->transitions = new ArrayCollection();
    }

}