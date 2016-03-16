<?php

namespace Modules\Event\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AbstractBaseController;
use Modules\Event\Repositories\EventRepository;
use Doctrine\ORM\EntityManagerInterface;

class EventController extends AbstractBaseController
{

    protected $eventRepository;
    protected $em;

    /**
     * Create a new authentication controller instance.
     *
     * @param EventRepository $eventRepository
     *   The accepted line repository.
     */
    public function __construct(EventRepository $eventRepository, EntityManagerInterface $em)
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->eventRepository = $eventRepository;
        $this->em = $em;

        // middleware to require login

    }

    public function getIndex() {

        $events = $this->eventRepository->findAll();

        return view('event::admin.event.index',['events'=>$events]);

    }

}