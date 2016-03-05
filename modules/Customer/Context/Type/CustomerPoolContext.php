<?php namespace Modules\Customer\Context\Type;

use Modules\Core\Context\Context;
use Modules\Customer\Contracts\Context\CustomerPool as CustomerPoolContract;
use Modules\Customer\Entities\CustomerPool as CustomerPoolEntity;

class CustomerPoolContext implements Context, CustomerPoolContract {

    protected $customerPool;

    public function __construct(CustomerPoolEntity $customerPool) {
        $this->customerPool = $customerPool;
    }

    public function getName() {
        return 'customer_pool';
    }

    public function getCustomerPoolId() {
        return $this->customerPool->getId();
    }

}