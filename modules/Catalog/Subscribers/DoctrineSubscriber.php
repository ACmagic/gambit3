<?php namespace Modules\Catalog\Subscribers;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Modules\Sales\Entities\Sale as SaleEntity;
use Modules\Sales\Entities\SaleAdvertisedLine;
use Modules\Sales\Entities\SaleWorkflowTransition;
use Carbon\Carbon;
use Modules\Catalog\Jobs\FulfillAdvertisedLine;
use Modules\Sales\Repositories\SaleWorkflowStateRepository;

class DoctrineSubscriber implements EventSubscriber {

    public function getSubscribedEvents() {

        return [
            Events::postPersist,
        ];

    }

    /**
     * Hanlde catalog entity post persist events.
     *
     * @param LifecycleEventArgs $event
     */
    public function postPersist(LifecycleEventArgs $event) {

        $em = $event->getObjectManager();
        $entity = $event->getObject();

        /**
         * @todo: Limit this to a single fulfillment.
         */
        if($entity instanceof SaleWorkflowTransition && $entity->getSale()->hasAdvertisedLine()) {

            $saleWorkflowStateRepo = app(SaleWorkflowStateRepository::class);

            $state = $entity->getAfterState();
            $paidState = $saleWorkflowStateRepo->findPaidState();


            if($state->getId() === $paidState->getId()) {
                $this->scheduleAdvertisedLineFulfillment($event);
            }

        }

    }

    /**
     * Schedule the fulfillment of sales advertised lines.
     *
     * @param LifecycleEventArgs $event
     */
    protected function scheduleAdvertisedLineFulfillment(LifecycleEventArgs $event) {

        $em = $event->getObjectManager();
        $entity = $event->getObject();

        $sale = $entity->getSale();

        foreach($sale->getItems() as $item) {
            if($item instanceof SaleAdvertisedLine) {
                $job = (new FulfillAdvertisedLine($item->getId()))->delay(10);
                dispatch($job);
            }
        }

    }

}