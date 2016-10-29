<?php namespace Modules\Catalog\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Catalog\Entities\AdvertisedLine;
use Modules\Sales\Repositories\SaleAdvertisedLineRepository;
use Modules\Sales\Repositories\SaleWorkflowStateRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Catalog\Exceptions\DuplicateLineException;
use Modules\Catalog\Repositories\LineWorkflowStateRepository;

class FulfillAdvertisedLine implements ShouldQueue {

    use Queueable;
    use InteractsWithQueue;

    protected $advertisedLineSaleId;

    public function __construct($advertisedLineSaleId) {
        $this->advertisedLineSaleId = $advertisedLineSaleId;
    }

    /**
     * Handle the job.
     *
     * @param SaleAdvertisedLineRepository $advertisedLineRepo
     *   The sale advertised line repository.
     *
     * @param SaleWorkflowStateRepository $saleWorkflowStateRepo
     *   The sale workflow state repo.
     *
     * @param LineWorkflowStateRepository $lineWorkflowStateRepo
     *   The line workflow state repository.
     */
    public function handle(
        SaleAdvertisedLineRepository $advertisedLineRepo,
        SaleWorkflowStateRepository $saleWorkflowStateRepo,
        LineWorkflowStateRepository $lineWorkflowStateRepo
    )
    {

        $saleAdvertisedLine = $advertisedLineRepo->findById($this->advertisedLineSaleId);
        $processingState = $saleWorkflowStateRepo->findProcessingState();
        $openState = $lineWorkflowStateRepo->findOpenState();

        $sale = $saleAdvertisedLine->getSale();
        $sale->setState($processingState);

        EntityManager::persist($sale);
        EntityManager::flush();

        // Cast sale advertised line to new line.
        $newLine = $saleAdvertisedLine->toLine();

        // Insert the advertised line
        $customer = $saleAdvertisedLine->getSale()->getCustomer();
        $side = $saleAdvertisedLine->getSide();
        $inventory = $saleAdvertisedLine->getInventory();
        $amount = $saleAdvertisedLine->getAmount();
        $amountMax = $saleAdvertisedLine->getAmountMax();
        $odds = $saleAdvertisedLine->getOdds();
        //$inverseOdds = $saleAdvertisedLine->getInverseOdds();

        $advertisedLine = new AdvertisedLine();
        $advertisedLine->setCreatedAt(Carbon::now());
        $advertisedLine->setUpdatedAt(Carbon::now());
        $advertisedLine->setCustomer($customer);
        $advertisedLine->setSide($side);
        $advertisedLine->setInventory($inventory);
        $advertisedLine->setAmount($amount);
        $advertisedLine->setAmountMax($amountMax);
        $advertisedLine->setOdds($odds);
        //$advertisedLine->setInverseOdds($inverseOdds);

        $advertisedLine->setLine($newLine);
        $newLine->addAdvertisedLine($advertisedLine);
        $newLine->setState($openState);

        try {

            EntityManager::persist($newLine);
            EntityManager::flush();

        } catch(DuplicateLineException $e) {

            /*
             * When the line already exists reassign to the matched line and
             * just persist the advertised line instead.
             */
            $matchedLine = $e->getMatchedLine();
            $advertisedLine->setLine($matchedLine);

            EntityManager::persist($advertisedLine);
            EntityManager::flush();

        }

        // Update the sale.
        $saleAdvertisedLine->setAdvertisedLine($advertisedLine);
        EntityManager::persist($saleAdvertisedLine);
        EntityManager::flush();


    }

}