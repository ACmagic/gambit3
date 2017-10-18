<?php namespace Modules\Catalog\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Catalog\Repositories\AdvertisedLineRepository;
use Modules\Sales\Repositories\SaleAdvertisedLineRepository;
use Modules\Catalog\Repositories\LineWorkflowStateRepository;
use Modules\Catalog\Repositories\LineRepository;
use Modules\Sales\Entities\ChargeBack;
use Carbon\Carbon;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Catalog\Entities\Side as SideEntity;

class PaybackLine implements ShouldQueue {

    use Queueable;
    use InteractsWithQueue;

    protected $lineId;

    public function __construct($lineId) {
        $this->lineId = $lineId;
    }

    public function handle(
        AdvertisedLineRepository $advertisedLineRepo,
        SaleAdvertisedLineRepository $saleAdvertisedLineRepo,
        LineWorkflowStateRepository $lineWorkflowStateRepo,
        LineRepository $lineRepo
    ) {

        // Update state
        $payingBackState = $lineWorkflowStateRepo->findPayingBackState();
        $paidBackState = $lineWorkflowStateRepo->findPaidBackState();

        $line = $lineRepo->findById($this->lineId);
        $line->setState($payingBackState);

        EntityManager::persist($line);
        EntityManager::flush();

        // Pay back the advertised lines.
        $ids = $advertisedLineRepo->findAllIdsWithLeftOverAmountsByLineId($this->lineId);
        foreach($ids as $id) {

            $leftOverAmount = $advertisedLineRepo->calculateAvailableAmount($id);
            if($leftOverAmount > 0) {

                $saleAdvertisedLine = $saleAdvertisedLineRepo->findByAdvertisedLineId($id);
                $sale = $saleAdvertisedLine->getSale();
                $side = $saleAdvertisedLine->getSide();
                $odds = $saleAdvertisedLine->getOdds();

                // Factor odds adjustment into left over amount.
                if($side->getMachineName() === SideEntity::SIDE_HOUSE && $odds != 0) {

                    if($odds < 0) {
                        $leftOverAmount = bcadd($leftOverAmount,bcdiv($leftOverAmount,bcmul($odds * -1,'.01',4),4),4);
                    } else {
                        $leftOverAmount = bcmul($leftOverAmount,bcmul($odds,'.01',4),4);
                    }

                }

                // Create the charge back.
                $chargeBack = new ChargeBack();
                $chargeBack->setSale($sale);
                $chargeBack->setAmount($leftOverAmount);
                $chargeBack->setPayback(true);
                $chargeBack->setMemo('Payback left over inventory.');
                $chargeBack->setCreatedAt(Carbon::now());
                $chargeBack->setUpdatedAt(Carbon::now());

                EntityManager::persist($chargeBack);

            }

        }

        // Update state to paid back.
        $line->setState($paidBackState);
        EntityManager::persist($line);

        EntityManager::flush();

    }

}