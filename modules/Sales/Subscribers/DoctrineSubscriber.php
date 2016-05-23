<?php namespace Modules\Sales\Subscribers;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Modules\Sales\Entities\Sale as SaleEntity;
use Modules\Sales\Entities\SaleWorkflowTransition;
use Carbon\Carbon;

class DoctrineSubscriber implements EventSubscriber {

    public function getSubscribedEvents() {

        return [
            Events::prePersist,
            Events::preUpdate,
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

        if($entity instanceof SaleEntity) {

            // Automate creation of transition.
            $state = $entity->getState();

            $transition = new SaleWorkflowTransition();
            $transition->setSale($entity);
            $transition->setAfterState($state);
            $transition->setCreatedAt(Carbon::now());
            $transition->setUpdatedAt(Carbon::now());

            $entity->addTransition($transition);

        }

    }

    /**
     * Handle preUpdate events on sale entities.
     *
     * @param LifecycleEventArgs $event
     */
    public function preUpdate(LifecycleEventArgs $event) {

        $em = $event->getObjectManager();
        $entity = $event->getObject();

        if($entity instanceof SaleEntity) {

            $originalData = $em->getUnitOfWork()->getOriginalEntityData($entity);
            $x = 'y';

        }

    }

}