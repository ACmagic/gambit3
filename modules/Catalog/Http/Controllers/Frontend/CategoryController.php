<?php

namespace Modules\Catalog\Http\Controllers\Frontend;

use Modules\Core\Http\Controllers\Frontend\AbstractBaseController;
use Modules\Event\Repositories\EventRepository;
use Modules\Event\Repositories\CategoryRepository;

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
        $events = $this->eventRepository->findEventsByCategory($categoryId);

        return view('catalog::frontend.category.index',['events'=>$events,'category'=>$category]);

    }

}