<?php namespace Modules\Core\Http\ViewComposers\Admin\Store;

use Illuminate\View\View;
use Modules\Core\Repositories\StoreRepository;

class DataGridComposer {

    protected $storeRepository;

    public function __construct(StoreRepository $storeRepository) {

        $this->storeRepository = $storeRepository;

    }

    public function compose(View $view) {

        $stores = $this->storeRepository->findAll();
        $view->with('stores',$stores);

    }

}