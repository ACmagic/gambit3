<?php

namespace Modules\Catalog\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Catalog\Repositories\LineRepository;
use Modules\Catalog\Repositories\AcceptedLineRepository;
use Modules\Catalog\Repositories\LineWorkflowStateRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Catalog\Contracts\Entities\Line as LineContract;
use Modules\Accounting\Entities\Posting;
use Modules\Accounting\Repositories\PostingEventRepository;
use Modules\Accounting\Repositories\AssetTypeRepository;
use Modules\Catalog\Entities\Side as SideEntity;

class PayoutLine implements ShouldQueue {

    use Queueable;
    use InteractsWithQueue;

    protected $lineId;

    /**
     * @var AcceptedLineRepository
     */
    protected $acceptedLineRepo;

    /**
     * @var PostingEventRepository
     */
    protected $postingEventRepo;

    /**
     * @var AssetTypeRepository
     */
    protected $assetTypeRepo;

    public function __construct($lineId) {
        $this->lineId = $lineId;
    }

    public function handle(
        LineRepository $lineRepo,
        AcceptedLineRepository $acceptedLineRepo,
        LineWorkflowStateRepository $lineWorkflowStateRepo,
        PostingEventRepository $postingEventRepo,
        AssetTypeRepository $assetTypeRepo
    ) {

        $this->acceptedLineRepo = $acceptedLineRepo;
        $this->postingEventRepo = $postingEventRepo;
        $this->assetTypeRepo = $assetTypeRepo;

        // @todo: Prevent line from being payed out multiple times.

        // Update the state to paying out during the payout process.
        $payingOutState = $lineWorkflowStateRepo->findPayingOutState();
        $doneState = $lineWorkflowStateRepo->findDoneState();

        $line = $lineRepo->findById($this->lineId);
        $line->setState($payingOutState);

        // Change state to paying out.
        EntityManager::persist($line);
        EntityManager::flush();

        if($line->isAdvertiserWinner()) {
            $this->payoutAdvertiser($line);
        } else {
            $this->payoutAcceptees($line);
        }

        // Update the state to done to complete pay out process.
        $line->setState($doneState);
        EntityManager::persist($line);
        EntityManager::flush();

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

        // Site cashbook.
        $cashbook = $line->getStore()->getSite()->getCashBook();

        // Posting event type (transfer)
        $transfer = $this->postingEventRepo->findTransferEvent();

        // Asset type of transaction (credit)
        $creditAsset = $this->assetTypeRepo->findCreditAssetType();

        // @todo: Implement batch processing / pagination.
        $total = count($advertisedLines);
        $start = 0;
        $limit = 100; // 1 for testing.

        $pagedAdvertisedLines = $advertisedLines->slice($start,$limit);

        foreach($pagedAdvertisedLines as $advertisedLine) {

            // Get the customers account.
            $customerInternalAccount = $advertisedLine->getCustomer()->getInternalAccount();

            // Get the side.
            $side = $advertisedLine->getSide();

            // Get the odds.
            $odds = $advertisedLine->getOdds();

            // Calculate the amount.
            $amount = $this->acceptedLineRepo->sumTotalAmountByAdvertisedLineId($advertisedLine->getId());

            // Adjust amount when odds are in play for an advertiser that acted as the house.
            if($side->getMachineName() === SideEntity::SIDE_HOUSE && $odds != 0) {

                if($odds < 0) {
                    $amount = bcadd($amount,bcadd($amount,bcdiv($amount,bcmul($odds * -1,'.01',4),4),4),4);
                } else {
                    $amount = bcadd($amount,bcmul($amount,bcmul($odds,'.01',4),4),4);
                }

            }

            // Execute the transaction logic.
            $debit = new Posting();
            $credit = new Posting();

            $debit->setAccount($cashbook);
            $debit->setEvent($transfer);
            $debit->setAssetType($creditAsset);
            $debit->setAmount(bcmul($amount,-1,4));
            $debit->setCreatedAt(Carbon::now());
            $debit->setUpdatedAt(Carbon::now());

            $credit->setAccount($customerInternalAccount);
            $credit->setEvent($transfer);
            $credit->setAssetType($creditAsset);
            $credit->setAmount(bcmul($amount,1,4));
            $credit->setCreatedAt(Carbon::now());
            $credit->setUpdatedAt(Carbon::now());

            $advertisedLine->addPayout($debit);
            $advertisedLine->addPayout($credit);

            //echo $advertisedLine->getId();

            // Persists postings through advertised line.
            EntityManager::persist($advertisedLine);
            EntityManager::flush();

        }

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