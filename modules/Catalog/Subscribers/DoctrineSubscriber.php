<?php namespace Modules\Catalog\Subscribers;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Modules\Sales\Entities\Sale as SaleEntity;
use Modules\Sales\Entities\SaleAdvertisedLine;
use Carbon\Carbon;
use Modules\Catalog\Jobs\FulfillAdvertisedLine;

class DoctrineSubscriber implements EventSubscriber {

    public function getSubscribedEvents() {

        return [
            Events::prePersist,
        ];

    }

    /**
     * Hanlde catalog entity post persist events.
     *
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event) {

        $em = $event->getObjectManager();
        $entity = $event->getObject();

        /**
         * @todo: This should occur after the sale gets created, right?
         */
        if($entity instanceof SaleEntity && !$entity->getId()) {

            if($entity->hasAdvertisedLine()) {
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
        
        foreach($entity->getItems() as $item) {
            
            if($item instanceof SaleAdvertisedLine) {
                
                $job = (new FulfillAdvertisedLine())->delay(30);
                dispatch($job);
                
            }
            
        }

    }

}