<?php namespace Modules\Core\Faker\Provider;

use Faker\Provider\Base;

/*
 * String manipulation providers.
 */
class Strings extends Base {

    public function concat() {

        $args = func_get_args();
        return implode('',$args);

    }

}