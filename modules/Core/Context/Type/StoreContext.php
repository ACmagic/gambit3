<?php namespace Modules\Core\Context\Type;

use Modules\Core\Context\Context;
use Modules\Core\Contracts\Context\Store as StoreContract;
use Modules\Core\Entities\Store as StoreEntity;

class StoreContext implements Context, StoreContract {

    protected $store;

    public function __construct(StoreEntity $store) {
        $this->store = $store;
    }

    public function getName() {
        return 'store';
    }

    public function getStoreId() {
        return $this->store->getId();
    }

}