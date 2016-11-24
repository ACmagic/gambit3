<?php namespace Modules\Catalog\Entities;

use Modules\Workflow\Entities\State as StateEntity;

class LineWorkflowState extends StateEntity {

    const

        // Line can still be accepted -> No events associated with predictions have began.
        STATE_OPEN = 'open',

        // Line can no longer be accepted -> One or more events associated with predictions have began.
        STATE_CLOSED = 'closed',

        // Unused inventory is in the process of being distributed back as credits to advertiser(s).
        STATE_PAYINGBACK = 'payingback',

        // Unused inventory has been paid back to advertisers.
        STATE_PAIDBACK = 'paidback',

        // All predictions can be resolved.
        STATE_COMPLETE = 'complete',

        // Line is in the process of being paid out.
        STATE_PAYINGOUT = 'payingout',

        // Line has been paid out.
        STATE_DONE = 'done';

}