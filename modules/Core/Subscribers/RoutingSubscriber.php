<?php namespace Modules\Core\Subscribers;

use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Facades\Config;

class RoutingSubscriber {

    public function subscribe($events) {

        $events->listen(
            RouteMatched::class,
            'Modules\Core\Subscribers\RoutingSubscriber@onRouteMatched'
        );

    }

    public function onRouteMatched(RouteMatched $evt) {

        $uri = $evt->route->uri();

        // In admin change default guard.
        if(strpos($uri,'admin/') === 0) {
            Config::set('auth.defaults.guard','users');
        }

        // Replace standard auth with admin.auth middleware instead.
        if(strpos($uri,'oauth/') === 0) {

            $action = $evt->route->getAction();
            if(isset($action['middleware'])) {
                foreach($action['middleware'] as $index=>$middleware) {
                    if($middleware === 'auth') {

                        // Replace middleware.
                        $action['middleware'][$index] = 'auth.admin';

                        // Replace default gaurd.
                        Config::set('auth.defaults.guard','users');

                        $evt->route->setAction($action);
                        break;
                    }
                }
            }

        }

    }

}