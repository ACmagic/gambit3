<?php

namespace Modules\Catalog\Http\Controllers\Api;

use Modules\Core\Http\Controllers\Api\AbstractBaseController;
use Modules\Event\Repositories\EventRepository;
use Modules\Event\Repositories\CategoryRepository;
use JMS\Serializer\SerializerBuilder;

class CategoryController extends AbstractBaseController {

    /**
     * @var EventRepository
     */
    protected $eventRepository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    public function __construct(
        EventRepository $eventRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->eventRepository = $eventRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function getIndex($categoryId) {

        $category = $this->categoryRepository->findById($categoryId);
        $events = $this->eventRepository->findOpenEventsByCategory($categoryId);

        $data = [];

        foreach($events as $event) {

            //$item = [];
            //$item['id'] = $event->getId();

            $data[] = $event;
        }

        //return view('catalog::frontend.category.index',['events'=>$events,'category'=>$category]);

        //$serializer = SerializerBuilder::create()->build();
        //$jsonContent = $serializer->serialize($events, 'json');
        return response()->json($data); // or return it in a Response

    }

}