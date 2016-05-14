<?php namespace Modules\Checkout\Subscribers;

use Illuminate\Events\Dispatcher;
use Illuminate\Auth\Events\Login as LoginEvent;
use Modules\Customer\Entities\Customer as CustomerEntity;
use Modules\Checkout\Facades\Cart as CartFacade;
use Illuminate\Support\Facades\Session;
use LaravelDoctrine\ORM\Facades\EntityManager;

class AuthSubscriber {

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Dispatcher  $events
     */
    public function subscribe($events) {

        $events->listen(
            LoginEvent::class,
            'Modules\Checkout\Subscribers\AuthSubscriber@onLogin'
        );

    }

    /**
     * handle login event.
     *
     * @param LoginEvent $event
     *   The login event.
     */
    public function onLogin(LoginEvent $event) {

        $user = $event->user;

        if($user instanceof CustomerEntity) {
            $this->transferQuote($user);
        }

    }

    /**
     * Transfer existing quote to customer.
     *
     * @param CustomerEntity $customer
     *   The customer.
     */
    protected function transferQuote(CustomerEntity $customer) {

        $quote = CartFacade::getQuote();

        $sessionId = Session::driver()->getId();

        $quote->setSessionId($sessionId);
        $quote->setCustomer($customer);

        EntityManager::persist($quote);
        EntityManager::flush();

    }

}