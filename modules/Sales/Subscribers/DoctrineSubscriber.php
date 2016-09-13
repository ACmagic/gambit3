<?php namespace Modules\Sales\Subscribers;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Modules\Sales\Entities\Sale as SaleEntity;
use Modules\Sales\Entities\SaleItem as SaleItemEntity;
use Modules\Sales\Entities\SaleWorkflowTransition;
use Modules\Sales\Entities\SaleItemWorkflowTransition;
use Carbon\Carbon;

class DoctrineSubscriber implements EventSubscriber {

    public function getSubscribedEvents() {

        return [
            Events::prePersist,
            Events::onFlush,
        ];

    }

    /**
     * Handle prePersist events on sale entities.
     *
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event) {

        $em = $event->getObjectManager();
        $entity = $event->getObject();

        if($entity instanceof SaleEntity || $entity instanceof SaleItemEntity) {

            // Automate creation of transition.
            $state = $entity->getState();

            if($entity instanceof SaleEntity) {
                $transition = new SaleWorkflowTransition();
                $transition->setSale($entity);
            } else {
                $transition = new SaleItemWorkflowTransition();
                $transition->setSaleItem($entity);
            }

            $transition->setAfterState($state);
            $transition->setCreatedAt(Carbon::now());
            $transition->setUpdatedAt(Carbon::now());

            $entity->addTransition($transition);

        }

    }

    /**
     * Handle preUpdate events on sale and sale item entities.
     *
     * @param OnFlushEventArgs $event
     */
    public function onFlush(OnFlushEventArgs $event) {

        $em = $event->getEntityManager();
        $uow = $em->getUnitOfWork();

        foreach($uow->getScheduledEntityUpdates() as $entity) {

            if($entity instanceof SaleEntity || $entity instanceof SaleItemEntity) {

                $changeSet = $uow->getEntityChangeSet($entity);

                // Add state change/transition record.
                if(isset($changeSet['state'][1]) && $changeSet['state'][0]->getId() != $changeSet['state'][1]->getId()) {

                    $beforeState = $changeSet['state'][0];
                    $afterState = $changeSet['state'][1];

                    if($entity instanceof SaleEntity) {
                        $transition = new SaleWorkflowTransition();
                        $transition->setSale($entity);
                    } else {
                        $transition = new SaleItemWorkflowTransition();
                        $transition->setSaleItem($entity);
                    }

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

}