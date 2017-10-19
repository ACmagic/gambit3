<?php

namespace Modules\Catalog\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Catalog\Repositories\LineRepository;
use Modules\Catalog\Repositories\AcceptedLineRepository;
use Modules\Catalog\Repositories\LineWorkflowStateRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Catalog\Contracts\Entities\Line as LineContract;

class PayoutLine implements ShouldQueue {

    use Queueable;
    use InteractsWithQueue;

    protected $lineId;

    /**
     * @var AcceptedLineRepository
     */
    protected $acceptedLineRepo;

    public function __construct($lineId) {
        $this->lineId = $lineId;
    }

    public function handle(
        LineRepository $lineRepo,
        AcceptedLineRepository $acceptedLineRepo,
        LineWorkflowStateRepository $lineWorkflowStateRepo
    ) {

        $this->acceptedLineRepo = $acceptedLineRepo;

        // @todo: Prevent line from being payed out multiple times.

        // Update the state to paying out during the payout process.
        $payingOutState = $lineWorkflowStateRepo->findPayingOutState();
        $doneState = $lineWorkflowStateRepo->findDoneState();

        $line = $lineRepo->findById($this->lineId);
        //$line->setState($payingOutState);

        if($line->isAdvertiserWinner()) {
            $this->payoutAdvertiser($line);
        } else {
            $this->payoutAcceptees($line);
        }

        //EntityManager::persist($line);
        //EntityManager::flush();

        // Pay out the line.


        // Update the state to done to complete pay out process.
        //$line->setState($doneState);

        //EntityManager::persist($line);
        //EntityManager::flush();

    }

    /**
     * Payout implementation for advertiser winner.
     *
     * @param LineContract $line
     *   The line to payout.
     *
     * @return void
     */
    protected function payoutAdvertiser(LineContract $line) {

        $advertisedLines = $line->getAdvertisedLines();

        $total = count($advertisedLines);

        $start = 0;
        $limit = 1; // 1 for testing.

        $pagedAdvertisedLines = $advertisedLines->slice($start,$limit);

        foreach($pagedAdvertisedLines as $advertisedLine) {

            $amount = $this->acceptedLineRepo->sumTotalAmountByAdvertisedLineId($advertisedLine->getId());

            echo $advertisedLine->getId();
        }

        // Iterate through each advertised line
        //$line->getAdvertisedLines()
          // calculate payout for advertised line

    }

    /**
     * Payout implementation for acceptees winner.
     *
     * @param LineContract $line
     *   The line to payout.
     *
     * @return void.
     */
    protected function payoutAcceptees(LineContract $line) {

    }

}