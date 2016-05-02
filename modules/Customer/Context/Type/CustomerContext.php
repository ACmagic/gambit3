<?php namespace Modules\Customer\Context\Type;

use Modules\Core\Context\Context;
use Modules\Customer\Contracts\Context\Customer as CustomerContract;
use Modules\Customer\Entities\Customer as CustomerEntity;

class CustomerContext implements Context, CustomerContract {

    protected $customer;

    public function __construct(CustomerEntity $customer=null) {
        $this->customer = $customer;
    }

    public function getName() {
        return 'customer';
    }

    public function isLoggedIn() {
        return $this->customer !== null;
    }

    public function getCustomerId() {
        return $this->customer->getAuthIdentifier();
    }

}