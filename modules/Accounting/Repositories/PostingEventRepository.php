<?php namespace Modules\Accounting\Repositories;

use Modules\Accounting\Entities\PostingEvent;

interface PostingEventRepository {


    public function findById($id);
    public function findAll();

    /**
     * @return PostingEvent
     */
    public function findWithdrawalEvent();

    /**
     * @return PostingEvent
     */
    public function findTransferEvent();

    /**
     * @return PostingEvent
     */
    public function findDepositEvent();

}