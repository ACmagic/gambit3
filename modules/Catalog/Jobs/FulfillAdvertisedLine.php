<?php namespace Modules\Catalog\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Catalog\Repositories\LineRepository;
use Modules\Catalog\Entities\AdvertisedLine;
use Modules\Sales\Repositories\SaleAdvertisedLineRepository;
use Modules\Sales\Repositories\SaleWorkflowStateRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;

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
     */
    public function handle(
        SaleAdvertisedLineRepository $advertisedLineRepo,
        SaleWorkflowStateRepository $saleWorkflowStateRepo
    )
    {

        $saleAdvertisedLine = $advertisedLineRepo->findById($this->advertisedLineSaleId);
        $processingState = $saleWorkflowStateRepo->findProcessingState();

        $sale = $saleAdvertisedLine->getSale();

        $sale->setState($processingState);

        EntityManager::persist($sale);
        EntityManager::flush();

        echo 'Fulfill Advertised Line Sale '.$saleAdvertisedLine->getId().'!';

        return;

        // Convert sale advertised line to line.
        $newLine = $saleAdvertisedLine->toLine();

        // Find match
        // First match the line with same number of predictions.
        $existingLine = $lineRepo->matchOpenLine($newLine);

        // Get the sales customer.
        $customer = $saleAdvertisedLine->getSale()->getCustomer();
        $inventory = $saleAdvertisedLine->getInventory();
        $amount = $saleAdvertisedLine->getAmount();
        $amountMax = $saleAdvertisedLine->getAmountMax();

        // Now make the advertised line.
        $advertisedLine = new AdvertisedLine();
        $advertisedLine->setCustomer($customer);
        $advertisedLine->setInventory($inventory);
        $advertisedLine->setAmount($amount);
        $advertisedLine->setAmountMax($amountMax);

        // When no existing line exists make the line.
        if(!$existingLine) {
            $advertisedLine->setLine($newLine);
            $em->persist($newLine);
        } else {
            $advertisedLine->setLine($existingLine);
        }

        // Add advertised line to unit of work.
        $em->persist($advertisedLine);

        // Flush it
        $em->flush();

    }

}