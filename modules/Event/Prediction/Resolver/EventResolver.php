<?php namespace Modules\Event\Prediction\Resolver;

use Modules\Prediction\PredictableResolver;
use Modules\Event\Repositories\EventRepository;
use Modules\Prediction\Predictable;
use Modules\Event\Entities\Event as EventEntity;

class EventResolver implements PredictableResolver {

    protected $eventRepo;

    public function __construct(EventRepository $eventRepo) {
        $this->eventRepo = $eventRepo;
    }

    public function getName() {
        return 'event';
    }

    public function getById($id) {
        $event = $this->eventRepo->findById($id);
        return $event;
    }

    public function owns(Predictable $predictable) {
        return $predictable instanceof EventEntity;
    }

    public function pluckId(Predictable $predictable) {
        return $predictable->getId();
    }

}