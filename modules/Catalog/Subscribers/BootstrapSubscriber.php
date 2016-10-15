<?php namespace Modules\Catalog\Subscribers;

use Modules\Catalog\Routing\CategoryRoute;
use Modules\Event\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Route as RouteFacade;

class BootstrapSubscriber {

    public function subscribe($events) {

        $events->listen(
            'bootstrapped: Illuminate\Foundation\Bootstrap\BootProviders',
            'Modules\Catalog\Subscribers\BootstrapSubscriber@onBootstrappedBootProviders'
        );

    }

    public function onBootstrappedBootProviders($event) {

        $categoryRepository = app(CategoryRepository::class);
        RouteFacade::getRoutes()->add(new CategoryRoute($categoryRepository));

    }

}