<?php namespace Modules\Catalog\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Catalog\Repositories\LineRepository;
use Modules\Catalog\Entities\AdvertisedLine;
use Modules\Sales\Repositories\SaleAdvertisedLineRepository;

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
     */
    public function handle(
        SaleAdvertisedLineRepository $advertisedLineRepo
    )
    {

        $saleAdvertisedLine = $advertisedLineRepo->findById($this->advertisedLineSaleId);

        echo 'Fulfill Advertised Line Sale '.$saleAdvertisedLine->getId().'!';

        return;

        // Convert sale advertised line to line.
        $newLine = $saleAdvertisedLine->toLine();

        // Find match
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