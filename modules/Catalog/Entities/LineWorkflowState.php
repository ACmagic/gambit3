<?php namespace Modules\Catalog\Entities;

use Modules\Workflow\Entities\State as StateEntity;

class LineWorkflowState extends StateEntity {

    const

        // Line can still be accepted -> No events associated with predictions have began.
        STATE_OPEN = 'open',

        // Line can no longer be accepted -> One or more events associated with predictions have began.
        STATE_CLOSED = 'closed';

        // All predictions can be resolved.
        //STATE_RESOLVED = 'resolved',

        // Line has been paid out.
        //STATE_PAIDOUT = 'paidout';

}