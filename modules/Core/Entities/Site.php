<?php namespace Modules\Core\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Carbon\Carbon;
use Modules\Accounting\Entities\AccountType;
use Modules\Accounting\Entities\Account as AccountEntity;

class Site {

    protected $id;
    protected $machineName;
    protected $creator;
    protected $accounts;
    protected $createdAt;
    protected $updatedAt;
    protected $stores;

    public function __construct() {
        $this->stores = new ArrayCollection();
        $this->accounts = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function getMachineName() {
        return $this->machineName;
    }

    public function setMachineName($machineName) {
        $this->machineName = $machineName;
    }

    public function setCreator(User $creator) {
        $this->creator = $creator;
    }

    public function getCreator() {
        return $this->creator;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt(Carbon $createdAt) {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setUpdatedAt(Carbon $updatedAt) {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Get the cashbook account.
     *
     * @return AccountEntity
     */
    public function getCashBook() {

        foreach($this->accounts as $account) {
            if($account->getType()->getMachineName() === AccountType::TYPE_CASHBOOK) {
                return $account;
            }
        }

    }

}