<?php namespace Modules\Sales\Mappings;

use LaravelDoctrine\Fluent\EntityMapping;
use LaravelDoctrine\Fluent\Fluent;
use Modules\Sales\Entities\SaleItem;
use Modules\Sales\Entities\Sale;
use Modules\Sales\Entities\SaleAdvertisedLine;
use Modules\Sales\Entities\SaleAcceptedLine;
use Modules\Sales\Entities\SaleCredit;

class SaleItemMapping extends EntityMapping {

    /**
     * @inheritdoc
     */
    public function mapFor() {
        return SaleItem::class;
    }

    /**
     * @inheritdoc
     */
    public function map(Fluent $builder) {

        $builder->table('sale_items');
        $builder->bigIncrements('id');
        $builder->belongsTo(Sale::class,'sale');
        $builder->timestamp('createdAt');
        $builder->timestamp('updatedAt');

        $builder->joinedTableInheritance()
            ->column('type')
            ->map(SaleItem::class,SaleItem::class)
            ->map(SaleAdvertisedLine::class,SaleAdvertisedLine::class)
            ->map(SaleAcceptedLine::class,SaleAcceptedLine::class)
            ->map(SaleCredit::class,SaleCredit::class);
    }

}