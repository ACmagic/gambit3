<?php namespace Modules\Customer\Contracts\Context;

use Modules\Customer\Entities\Customer as CustomerEntity;

interface CustomerPool {

    public function getCustomerPoolId();
    public function associateCustomer(CustomerEntity $customer);

}