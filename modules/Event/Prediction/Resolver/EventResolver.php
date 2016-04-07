<?php namespace Modules\Event\Prediction\Resolver;

use Modules\Prediction\PredictableResolver;
use Modules\Event\Repositories\EventRepository;

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

}