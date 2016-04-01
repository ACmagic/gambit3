<?php namespace Modules\Core\Faker\Provider;

use Faker\Provider\Base;

/*
 * Expose Laravel helpers to faker.
 */
class Helpers extends Base {

    public function bcrypt($value, $options = []) {

        return bcrypt($value,$options);

    }

}