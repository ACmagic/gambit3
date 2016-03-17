<?php namespace Modules\Sports\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Sports\Entities\Player;
use LaravelDoctrine\Fluent\Fluent;

class PlayerMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Player::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('sports_players');
        $builder->string('firstName')->length(57);
        $builder->string('lastName')->length(57);
        $builder->string('middleName')->length(57);
    }

}