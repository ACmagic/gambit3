<?php namespace Modules\Event\Http\Controllers\Frontend;

use Modules\Core\Http\Controllers\Frontend\AbstractBaseController;
use Modules\Event\Repositories\EventRepository;

class EventController extends AbstractBaseController {

    protected $eventRepo;

    public function __construct(EventRepository $eventRepo) {
        $this->eventRepo = $eventRepo;
    }

    public function getList() {

        $events = $this->eventRepo->findAll();
        return view('event::frontend.event.list',['events'=>$events]);

    }

}