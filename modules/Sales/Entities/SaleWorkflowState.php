<?php namespace Modules\Sales\Entities;

use Modules\Workflow\Entities\State as StateEntity;

class SaleWorkflowState extends StateEntity {

    const

        STATE_SUBMITTED = 'submitted',
        STATE_PAID = 'paid',
        STATE_PROCESSING = 'processing',
        STATE_PROCESSED = 'processed';

}