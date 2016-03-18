<?php namespace Modules\Vegas\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Vegas\Entities\MoneyLine;
use Modules\Sports\Entities\Team;
use LaravelDoctrine\Fluent\Fluent;

class MoneyLineMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return MoneyLine::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('money_lines');
        $builder->belongsTo(Team::class,'pick');
    }

}