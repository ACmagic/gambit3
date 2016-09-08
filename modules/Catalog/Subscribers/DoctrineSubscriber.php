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
use Modules\Catalog\Entities\Line as LineEntity;
use Modules\Catalog\Repositories\LineRepository;
use Modules\Catalog\Exceptions\DuplicateLineException;

class DoctrineSubscriber implements EventSubscriber {

    public function getSubscribedEvents() {

        return [
            Events::postPersist,
            Events::prePersist
        ];

    }

    /**
     * Handle catalog entity post persist events.
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
     * Handle catalog entity prePersist events.
     *
     * @throws \Exception
     *
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event) {

        $entity = $event->getObject();

        if($entity instanceof LineEntity) {

            $lineRepository = app(LineRepository::class);
            $line = $lineRepository->matchOpenLine($entity);

            // Restricts "same" line from being created more than once.
            if($line !== NULL) {
                $exception = new DuplicateLineException();
                $exception->setMatchedLine($line);
                $exception->setNewLine($entity);
                throw $exception;
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