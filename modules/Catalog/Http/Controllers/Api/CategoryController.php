<?php

namespace Modules\Catalog\Http\Controllers\Api;

use Modules\Core\Http\Controllers\Api\AbstractBaseController;
use Modules\Event\Repositories\EventRepository;
use Modules\Event\Repositories\CategoryRepository;
use League\Fractal\Manager as FractalManager;
use League\Fractal\Resource\Collection;
use Modules\Event\Entities\Transformers\EventTransformer;
use League\Fractal\Pagination\DoctrinePaginatorAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CategoryController extends AbstractBaseController {

    /**
     * @var EventRepository
     */
    protected $eventRepository;

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * FractalManager
     */
    protected $fractal;

    public function __construct(
        EventRepository $eventRepository,
        CategoryRepository $categoryRepository,
        FractalManager $fractal
    ) {
        $this->eventRepository = $eventRepository;
        $this->categoryRepository = $categoryRepository;
        $this->fractal = $fractal;
    }

    public function getEvents($categoryId) {

        $category = $this->categoryRepository->findById($categoryId);
        $query = $this->eventRepository->buildQueryOpenEventsByCategory($category->getId());

        $query->setFirstResult(0);
        $query->setMaxResults(100);

        $paginator = new Paginator($query);
        $resource = new Collection($paginator,new EventTransformer());
        $paginatorAdapter = new DoctrinePaginatorAdapter($paginator,function() {

        });
        $resource->setPaginator($paginatorAdapter);

        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data); // or return it in a Response

    }

}