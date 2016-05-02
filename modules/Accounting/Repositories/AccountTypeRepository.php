<?php namespace Modules\Accounting\Repositories;

use Modules\Accounting\Entities\AccountType;

interface AccountTypeRepository {


    public function findById($id);
    public function findAll();

    /**
     * @return AccountType
     */
    public function findExternalType();

    /**
     * @return AccountType
     */
    public function findInternalType();

}