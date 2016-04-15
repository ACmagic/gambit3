<?php namespace Modules\Accounting\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Accounting\Entities\AssetType;

class AssetTypeMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return AssetType::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('asset_types');
        $builder->smallIncrements('id');
        $builder->string('machineName')->length(128)->default('')->unique();
        $builder->string('humanName')->length(128)->default('')->unique();
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
    }

}