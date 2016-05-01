<?php namespace Modules\Accounting\Subscribers;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Modules\Customer\Entities\Customer as CustomerEntity;
use Modules\Accounting\Entities\Account as AccountEntity;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Modules\Accounting\Repositories\AccountTypeRepository;
use Carbon\Carbon;

class DoctrineSubscriber implements EventSubscriber {

    protected $accountTypeRepo;

    public function getSubscribedEvents() {

        return [
            Events::prePersist
        ];

    }

    /**
     * Add accounts for new customers.
     *
     * @param LifecycleEventArgs $event
     */
    public function prePersist(LifecycleEventArgs $event) {

        $em = $event->getObjectManager();
        $entity = $event->getObject();

        if($entity instanceof CustomerEntity && !$entity->getId()) {
            $this->addDefaultCustomerAccounts($event);
        }

    }

    /**
     * Add customer accounts.
     *
     * @param LifecycleEventArgs $event
     */
    protected function addDefaultCustomerAccounts($event) {

        $em = $event->getObjectManager();
        $customer = $event->getObject();

        $accountTypeRepo = app(AccountTypeRepository::class);

        $internalType = $accountTypeRepo->findInternalType();
        $externalType = $accountTypeRepo->findExternalType();

        $internalAccount = new AccountEntity();
        $internalAccount->setType($internalType);
        $internalAccount->setBalance(0);
        $internalAccount->setCreatedAt(Carbon::now());
        $internalAccount->setUpdatedAt(Carbon::now());

        $externalAccount = new AccountEntity();
        $externalAccount->setType($externalType);
        $externalAccount->setBalance(0);
        $externalAccount->setCreatedAt(Carbon::now());
        $externalAccount->setUpdatedAt(Carbon::now());

        $customer->addAccount($internalAccount);
        $customer->addAccount($externalAccount);

        $uow = $em->getUnitOfWork();

        /*$uow->recomputeSingleEntityChangeSet(
            $em->getClassMetadata(get_class($customer)),
            $customer
        );*/

    }

}