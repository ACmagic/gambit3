<?php namespace Modules\Accounting\Repositories;

use Modules\Accounting\Entities\Account;

interface AccountRepository {


    public function findById($id);
    public function findAll();
    public function calculateAccountBalance(Account $account);

}