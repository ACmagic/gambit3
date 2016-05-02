<?php namespace Modules\Accounting\Repositories\Doctrine;

use Modules\Accounting\Repositories\PostingEventRepository;
use Doctrine\Common\Persistence\ObjectRepository;
use Modules\Accounting\Entities\PostingEvent as PostingEvent;

class DoctrinePostingEventRepository implements PostingEventRepository {

    protected $genericRepository;

    public function __construct(ObjectRepository $genericRepository) {
        $this->genericRepository = $genericRepository;
    }

    public function findById($id) {
        return $this->genericRepository->find($id);
    }

    public function findAll() {
        return $this->genericRepository->findAll();
    }

    /**
     * @return PostingEvent
     */
    public function findWithdrawalEvent() {

        return $this->genericRepository->findOneByMachineName(PostingEvent::EVENT_WITHDRAWAL);
        
    }

    /**
     * @return PostingEvent
     */
    public function findTransferEvent() {

        return $this->genericRepository->findOneByMachineName(PostingEvent::EVENT_TRANSFER);
        
    }

    /**
     * @return PostingEvent
     */
    public function findDepositEvent() {

        return $this->genericRepository->findOneByMachineName(PostingEvent::EVENT_DEPOSIT);
        
    }

}