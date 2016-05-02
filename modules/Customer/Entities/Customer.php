<?php namespace Modules\Customer\Entities;

use LaravelDoctrine\ORM\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Doctrine\Common\Collections\ArrayCollection;
use Carbon\Carbon;
use Modules\Accounting\Entities\Account as AccountEntity;
use Modules\Accounting\Entities\AccountType as AccountTypeEntity;

class Customer implements AuthenticatableContract {

    use Authenticatable;

    protected $id;
    protected $email;
    protected $pool;
    protected $accounts;
    protected $createdAt;
    protected $updatedAt;

    public function __construct() {
        $this->accounts = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function setPool(CustomerPool $pool) {
        $this->pool = $pool;
    }

    public function getPool() {
        return $this->pool;
    }

    public function addAccount(AccountEntity $account) {
        $this->accounts[] = $account;
    }

    public function getInternalAccount() {

        foreach($this->accounts as $account) {
            if($account->getType()->getMachineName() === AccountTypeEntity::TYPE_INTERNAL) {
                return $account;
            }
        }
        
    }

    public function getExternalAccount() {

        foreach($this->accounts as $account) {
            if($account->getType()->getMachineName() === AccountTypeEntity::TYPE_EXTERNAL) {
                return $account;
            }
        }

    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
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

}