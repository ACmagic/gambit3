<?php namespace Modules\Core\Faker\Provider;

use Faker\Provider\Base;
use Carbon\Carbon as ActualCarbon;

/*
 * Use carbon dates.
 */
class Carbon extends Base {

    public function carbon_date($date) {

        return ActualCarbon::createFromDate($date);

    }

    public function carbon_now() {

        return ActualCarbon::now();

    }

}