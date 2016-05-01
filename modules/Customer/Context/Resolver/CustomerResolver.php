<?php namespace Modules\Customer\Context\Resolver;

use Modules\Core\Context\Resolver;
use Modules\Customer\Context\Type\CustomerContext;
use Illuminate\Contracts\Auth\Factory as AuthFactory;

class CustomerResolver implements Resolver {

    protected $auth;

    public function __construct(AuthFactory $auth) {
        $this->auth = $auth;
    }

    public function getName() {
        return 'customer_resolver';
    }

    public function resolves($contextType) {
        return $contextType == 'customer';
    }

    public function resolve() {

        $customer = $this->auth->guard('customers')->user();
        $context = new CustomerContext($customer);

        return $context;

    }

}