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

        $store = $this->storeRepository->findById(1);
        $context = new StoreContext($store);

        return $context;

    }

}