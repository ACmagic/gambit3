<?php namespace Modules\Catalog\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Core\Entities\Store;
use Modules\Catalog\Entities\Side;
use Modules\Catalog\Entities\Line;
use LaravelDoctrine\Fluent\Fluent;

class LineMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Line::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('`lines`');
        $builder->bigIncrements('id');
        $builder->belongsTo(Store::class,'store');
        $builder->belongsTo(Side::class,'side');
        $builder->integer('odds')->default(0);
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
    }

}