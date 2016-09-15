<?php namespace Modules\Catalog\Entities;

use Modules\Workflow\Entities\Transition;
use Modules\Catalog\Contracts\Entities\Line as LineContract;

class LineWorkflowTransition extends Transition {

    protected $line;

    public function getLine() : LineContract {
        return $this->line;
    }

    public function setLine(LineContract $line) {
        $this->line = $line;
    }

}