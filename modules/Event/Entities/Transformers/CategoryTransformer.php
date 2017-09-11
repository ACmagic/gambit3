<?php namespace Modules\Event\Entities\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Event\Entities\Category as CategoryEntity;

class CategoryTransformer extends TransformerAbstract {

    public function transform(CategoryEntity $category) {
        return [
            'id'=> $category->getId(),
            'humanName'=> $category->getHumanName()
        ];
    }

}