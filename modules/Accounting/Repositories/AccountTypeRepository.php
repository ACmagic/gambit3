<?php namespace Modules\Accounting\Repositories;

use Modules\Accounting\Entities\AccountType;

interface AccountTypeRepository {

    const

        TYPE_INTERNAL = 'internal',
        TYPE_EXTERNAL = 'external',
        TYPE_CASHBOOK = 'cashbook';


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