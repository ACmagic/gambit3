<?php namespace Modules\Customer\Contracts\Context;

interface Customer {

    public function isLoggedIn();
    public function getCustomerId();

}