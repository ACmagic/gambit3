<?php namespace Modules\Catalog\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use Modules\Customer\Entities\Customer;
use Modules\Catalog\Entities\Line;
use Modules\Catalog\Entities\AdvertisedLine;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Catalog\Entities\AcceptedLine;
use Modules\Accounting\Entities\Posting as PostingEntity;

class AdvertisedLineMapping extends EntityMapping {

    use AdvertisedLineMappingTrait;

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return AdvertisedLine::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {
        $builder->table('advertised_lines');
        $builder->bigIncrements('id');

        $builder->hasMany(AcceptedLine::class,'acceptedLines')->mappedBy('advertisedLine')->fetchExtraLazy();

        // Payouts
        $builder->manyToMany(PostingEntity::class,'payouts')->joinTable('advertised_line_payouts')->cascadePersist()->fetchExtraLazy();

        // @todo: Was this a mistake
        //$builder->manyToMany(Account::class,'accounts')->joinTable('customer_accounts')->cascadePersist();

        $builder->belongsTo(Line::class,'line');
        $builder->belongsTo(Customer::class,'customer');

        $this->mapAdvertisedLine($builder);

        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');
    }

}