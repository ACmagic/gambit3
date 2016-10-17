<?php namespace Modules\Event\Entities;

use Modules\Workflow\Entities\State as StateEntity;

class EventWorkflowState extends StateEntity {

    const

        // Event has not started yet and betting is not yet allowed for this event.
        STATE_PENDING = 'pending',

        // Betting is "open" for event.
        STATE_OPEN = 'open',

        // Event is currently "inprogress".
        STATE_INPROGRESS = 'inprogress',

        // Event is complete.
        STATE_COMPLETE = 'complete',

        // All stats have been finalized for the event - bets can now be resolved that are associated with the event.
        STATE_DONE = 'done';

}