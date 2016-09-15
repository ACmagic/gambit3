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
use Modules\Catalog\Entities\LineWorkflowTransition;
use Doctrine\ORM\Event\OnFlushEventArgs;

class DoctrineSubscriber implements EventSubscriber {

    public function getSubscribedEvents() {

        return [
            Events::postPersist,
            Events::prePersist,
            Events::onFlush,
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

            // Automate creation of transition.
            $state = $entity->getState();

            $transition = new LineWorkflowTransition();
            $transition->setLine($entity);

            $transition->setAfterState($state);
            $transition->setCreatedAt(Carbon::now());
            $transition->setUpdatedAt(Carbon::now());

            $entity->addTransition($transition);

        }

    }

    /**
     * Handle preUpdate events on catalog entities.
     *
     * @param OnFlushEventArgs $event
     */
    public function onFlush(OnFlushEventArgs $event) {

        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach($uow->getScheduledEntityUpdates() as $entity) {

            if($entity instanceof LineEntity) {

                $changeSet = $uow->getEntityChangeSet($entity);

                // Add state change/transition record.
                if(isset($changeSet['state'][1]) && $changeSet['state'][0]->getId() != $changeSet['state'][1]->getId()) {

                    $beforeState = $changeSet['state'][0];
                    $afterState = $changeSet['state'][1];

                    $transition = new LineWorkflowTransition();
                    $transition->setLine($entity);

                    $transition->setBeforeState($beforeState);
                    $transition->setAfterState($afterState);
                    $transition->setCreatedAt(Carbon::now());
                    $transition->setUpdatedAt(Carbon::now());

                    $uow->persist($transition);

                    $meta = $em->getClassMetadata(get_class($transition));
                    $uow->computeChangeSet($meta, $transition);

                }

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