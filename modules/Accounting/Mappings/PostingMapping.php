<?php namespace Modules\Accounting\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Accounting\Entities\Account;
use Modules\Accounting\Entities\PostingEvent;
use Modules\Accounting\Entities\AssetType;
use Modules\Accounting\Entities\Posting;

class PostingMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return Posting::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('postings');
        $builder->bigIncrements('id');
        $builder->decimal('amount')->precision(16)->scale(4);
        $builder->belongsTo(Account::class,'account');
        $builder->belongsTo(PostingEvent::class,'event');
        $builder->belongsTo(AssetType::class,'assetType');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
    }

}