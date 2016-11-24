<?php

namespace Modules\Catalog\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Catalog\Repositories\LineRepository;
use Modules\Catalog\Repositories\LineWorkflowStateRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;

class PayoutLine implements ShouldQueue {

    use Queueable;
    use InteractsWithQueue;

    protected $lineId;

    public function __construct($lineId) {
        $this->lineId = $lineId;
    }

    public function handle(
        LineRepository $lineRepo,
        LineWorkflowStateRepository $lineWorkflowStateRepo
    ) {

        // @todo: Prevent line from being payed out multiple times.

        // Update the state to paying out during the payout process.
        $payingOutState = $lineWorkflowStateRepo->findPayingOutState();
        $doneState = $lineWorkflowStateRepo->findDoneState();

        $line = $lineRepo->findById($this->lineId);
        $line->setState($payingOutState);

        EntityManager::persist($line);
        EntityManager::flush();

        // Pay out the line.


        // Update the state to done to complete pay out process.
        $line->setState($doneState);

        EntityManager::persist($line);
        EntityManager::flush();

    }

}