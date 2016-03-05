<?php namespace Modules\Customer\Context\Resolver;

use Modules\Core\Context\Resolver;
use Modules\Customer\Context\Type\CustomerPoolContext;
use Modules\Core\Facades\Site;
use Modules\Customer\Repositories\CustomerPoolRepository;

class CustomerPoolResolver implements Resolver {

    protected $customerPoolRepository;

    public function __construct(CustomerPoolRepository $customerPoolRepository) {
        $this->customerPoolRepository = $customerPoolRepository;
    }

    public function getName() {
        return 'customer_pool_resolver';
    }

    public function resolves($contextType) {
        return $contextType == 'customer_pool';
    }

    public function resolve() {

        $siteId = Site::getSiteId();
        $customerPool = $this->customerPoolRepository->findBySiteId($siteId);
        $context = new CustomerPoolContext($customerPool);

        return $context;

    }

}