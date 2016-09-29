<?php namespace Modules\Catalog\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Catalog\Entities\AcceptedLine;
use Modules\Sales\Repositories\SaleAcceptedLineRepository;
use Modules\Sales\Repositories\SaleWorkflowStateRepository;
use LaravelDoctrine\ORM\Facades\EntityManager;

class FulfillAcceptedLine implements ShouldQueue {

    use Queueable;
    use InteractsWithQueue;

    protected $acceptedLineSaleId;

    public function __construct($acceptedLineSaleId) {
        $this->acceptedLineSaleId = $acceptedLineSaleId;
    }

    /**
     * Handle the job.
     *
     * @param SaleAcceptedLineRepository $acceptedLineRepo
     *   The sale accepted line repository.
     *
     * @param SaleWorkflowStateRepository $saleWorkflowStateRepo
     *   The sale workflow state repo.
     */
    public function handle(
        SaleAcceptedLineRepository $acceptedLineRepo,
        SaleWorkflowStateRepository $saleWorkflowStateRepo
    )
    {

        $saleAcceptedLine = $acceptedLineRepo->findById($this->acceptedLineSaleId);

        $processingState = $saleWorkflowStateRepo->findProcessingState();

        $sale = $saleAcceptedLine->getSale();
        $sale->setState($processingState);

        EntityManager::persist($sale);
        EntityManager::flush();

        $advertisedLine = $saleAcceptedLine->getAdvertisedLine();
        $customer = $sale->getCustomer();
        $amount = $saleAcceptedLine->getAmount();
        $quantity = $saleAcceptedLine->getQuantity();

        $acceptedLine = new AcceptedLine();
        $acceptedLine->setAdvertisedLine($advertisedLine);
        $acceptedLine->setCustomer($customer);
        $acceptedLine->setAmount($amount);
        $acceptedLine->setQuantity($quantity);
        $acceptedLine->setCreatedAt(Carbon::now());
        $acceptedLine->setUpdatedAt(Carbon::now());

        EntityManager::persist($acceptedLine);
        EntityManager::flush();

        $saleAcceptedLine->setAcceptedLine($acceptedLine);

        EntityManager::persist($saleAcceptedLine);
        EntityManager::flush();

    }

}