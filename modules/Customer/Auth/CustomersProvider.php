<?php namespace Modules\Customer\Auth;

use LaravelDoctrine\ORM\Auth\DoctrineUserProvider;
use Illuminate\Contracts\Auth\Authenticatable as IlluminateAuthenticatable;
use Modules\Customer\Facades\CustomerPool;

class CustomersProvider extends DoctrineUserProvider {

    /**
     * Retrieve a user by the given credentials.
     *
     * @param array $credentials
     *
     * @return IlluminateAuthenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        $criteria = [];

        foreach ($credentials as $key => $value) {
            if (!str_contains($key, 'password')) {
                $criteria[$key] = $value;
            }
        }

        // Use the current sites customer pool.
        $criteria['pool'] = CustomerPool::getCustomerPoolId();

        return $this->getRepository()->findOneBy($criteria);
    }

}