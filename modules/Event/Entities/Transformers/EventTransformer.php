<?php namespace Modules\Event\Entities\Transformers;

use League\Fractal\TransformerAbstract;
use Modules\Event\Entities\Event as EventEntity;

class EventTransformer extends TransformerAbstract {

    public function transform(EventEntity $event) {
        return [
            'id'=> $event->getId(),
            'display_title'=> $event->getDisplayTitle()
        ];
    }

}