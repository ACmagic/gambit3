<?php namespace Modules\Accounting\Subscribers;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Modules\Customer\Entities\Customer as CustomerEntity;
use Modules\Accounting\Entities\Account as AccountEntity;
use Modules\Sales\Entities\Sale as SaleEntity;
use Modules\Accounting\Repositories\AccountTypeRepository;
use Modules\Accounting\Repositories\PostingEventRepository;
use Modules\Accounting\Repositories\AssetTypeRepository;
use Modules\Accounting\Repositories\AccountRepository;
use Carbon\Carbon;
use Modules\Accounting\Entities\Posting as PostingEntity;

class DoctrineSubscriber implements EventSubscriber {

    protected $accountTypeRepo;

    public function getSubscribedEvents() {

        return [
            Events::prePersist,
            Events::postPersist,
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

            // @todo: Determine the property which will keep track of the state -- triggers account transfer.
        } else if($entity instanceof SaleEntity && !$entity->getId()) {

            if($entity->isPayableViaCredits()) {
                $this->executeSaleTransfer2($event);
            } else {
                $this->executeSaleTransfer($event);
            }

        }

    }

    /**
     * Add accounts for new customers.
     *
     * @param LifecycleEventArgs $event
     */
    public function postPersist(LifecycleEventArgs $event) {

        $em = $event->getObjectManager();
        $entity = $event->getObject();

        if($entity instanceof PostingEntity) {
            $this->recalculateAccountBalance($event);
        }

    }

    /**
     * Transfer funds between accounts for the specified sale.
     *
     * @param LifecycleEventArgs $event
     */
    protected function executeSaleTransfer($event) {

        $em = $event->getObjectManager();
        $sale = $event->getObject();
        
        $cost = $sale->calculateTotalCost();

        $postingEventRepo = app(PostingEventRepository::class);
        $assetTypeRepo = app(AssetTypeRepository::class);

        $cashbook = $sale->getStore()->getSite()->getCashBook();
        $customerExternalAccount = $sale->getCustomer()->getExternalAccount();
        $customerInternalAccount = $sale->getCustomer()->getInternalAccount();

        $transfer = $postingEventRepo->findTransferEvent();
        $deposit = $postingEventRepo->findDepositEvent();

        $cash = $assetTypeRepo->findUsdAssetType();
        $credit = $assetTypeRepo->findCreditAssetType();

        // Transfer CASH funds from customer external account to site cashbook.
        $posting = new PostingEntity();
        $posting->setAccount($customerExternalAccount);
        $posting->setEvent($transfer);
        $posting->setAssetType($cash);
        $posting->setAmount(bcmul($cost,-1,4));
        $posting->setCreatedAt(Carbon::now());
        $posting->setUpdatedAt(Carbon::now());

        $posting2 = new PostingEntity();
        $posting2->setAccount($cashbook);
        $posting2->setEvent($transfer);
        $posting2->setAssetType($cash);
        $posting2->setAmount($cost);
        $posting2->setCreatedAt(Carbon::now());
        $posting2->setUpdatedAt(Carbon::now());

        // Move funds from cashbook to customers account as CREDITS.
        $posting3 = new PostingEntity();
        $posting3->setAccount($cashbook);
        $posting3->setEvent($deposit);
        $posting3->setAssetType($credit);
        $posting3->setAmount(bcmul($cost,-1,4));
        $posting3->setCreatedAt(Carbon::now());
        $posting3->setUpdatedAt(Carbon::now());

        $posting4 = new PostingEntity();
        $posting4->setAccount($customerInternalAccount);
        $posting4->setEvent($deposit);
        $posting4->setAssetType($credit);
        $posting4->setAmount($cost);
        $posting4->setCreatedAt(Carbon::now());
        $posting4->setUpdatedAt(Carbon::now());

        // Associate transactions with the sale.
        $sale->addTransaction($posting);
        $sale->addTransaction($posting2);
        $sale->addTransaction($posting3);
        $sale->addTransaction($posting4);

    }

    /**
     * Transfer funds between accounts for the specified sale.
     *
     * @param LifecycleEventArgs $event
     */
    protected function executeSaleTransfer2($event) {

        $em = $event->getObjectManager();
        $sale = $event->getObject();

        $cost = $sale->calculateTotalCost();

        $postingEventRepo = app(PostingEventRepository::class);
        $assetTypeRepo = app(AssetTypeRepository::class);

        $cashbook = $sale->getStore()->getSite()->getCashBook();
        $customerInternalAccount = $sale->getCustomer()->getInternalAccount();

        $transfer = $postingEventRepo->findTransferEvent();

        $credit = $assetTypeRepo->findCreditAssetType();

        // Debit customer account.
        $posting = new PostingEntity();
        $posting->setAccount($customerInternalAccount);
        $posting->setEvent($transfer);
        $posting->setAssetType($credit);
        $posting->setAmount(bcmul($cost,-1,4));
        $posting->setCreatedAt(Carbon::now());
        $posting->setUpdatedAt(Carbon::now());

        $posting2 = new PostingEntity();
        $posting2->setAccount($cashbook);
        $posting2->setEvent($transfer);
        $posting2->setAssetType($credit);
        $posting2->setAmount($cost);
        $posting2->setCreatedAt(Carbon::now());
        $posting2->setUpdatedAt(Carbon::now());

        // Associate transactions with the sale.
        $sale->addTransaction($posting);
        $sale->addTransaction($posting2);

    }

    /**
     * Add customer accounts.
     *
     * @param LifecycleEventArgs $event
     */
    protected function addDefaultCustomerAccounts($event) {

        $em = $event->getObjectManager();
        $customer = $event->getObject();

        /*
         * This is a work around because em is returning the generic
         * object repository. We need to go through laravel to use type
         * hinting. I tried in injecting it within the constructor but
         * that results in an error. So this will work for now.
         */
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

        /*
         * This doesn't need to be done because the customer is not managed entity it is brand new.
         */
        /*$uow->recomputeSingleEntityChangeSet(
            $em->getClassMetadata(get_class($customer)),
            $customer
        );*/

    }

    /**
     * Recalculate the balance of the associated account.
     *
     * @param LifecycleEventArgs $event
     */
    protected function recalculateAccountBalance(LifecycleEventArgs $event) {

        $em = $event->getObjectManager();
        $posting = $event->getObject();

        $accountRepo = app(AccountRepository::class);
        $account = $posting->getAccount();
        
        $balance = $accountRepo->calculateAccountBalance($account);
        $account->setBalance($balance);

        $em->persist($account);
        $em->flush();

    }

}