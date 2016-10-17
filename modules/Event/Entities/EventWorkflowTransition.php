<?php namespace Modules\Event\Entities;

use Modules\Workflow\Entities\Transition;

class EventWorkflowTransition extends Transition {

    protected $event;

    public function getEvent() {
        return $this->event;
    }

    public function setEvent(Event $event) {
        $this->event = $event;
    }

}