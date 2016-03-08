<?php namespace Modules\Core\Context\Resolver;

use Modules\Core\Context\Resolver;
use Modules\Core\Context\Type\StoreContext;
use Modules\Core\Repositories\StoreRepository;

class StoreResolver implements Resolver {

    protected $storeRepository;

    public function __construct(StoreRepository $storeRepository) {
        $this->storeRepository = $storeRepository;
    }

    public function getName() {
        return 'store_resolver';
    }

    public function resolves($contextType) {
        return $contextType == 'store';
    }

    public function resolve() {

        $storeKey = env('APP_STORE');
        $store = $this->storeRepository->findByMachineName($storeKey);
        $context = new StoreContext($store);

        return $context;

    }

}