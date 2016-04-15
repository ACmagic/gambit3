<?php namespace Modules\Accounting\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Accounting\Entities\PostingEvent;

class PostingEventMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return PostingEvent::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('posting_events');
        $builder->smallIncrements('id');
        $builder->string('machineName')->length(128)->default('')->unique();
        $builder->string('humanName')->length(128)->default('')->unique();
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
    }

}