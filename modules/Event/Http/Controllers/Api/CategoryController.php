<?php

namespace Modules\Event\Http\Controllers\Api;

use Modules\Core\Http\Controllers\Api\AbstractBaseController;
use Modules\Event\Repositories\CategoryRepository;
use League\Fractal\Manager as FractalManager;
use League\Fractal\Resource\Collection;
use Modules\Event\Entities\Transformers\CategoryTransformer;
use League\Fractal\Pagination\DoctrinePaginatorAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CategoryController extends AbstractBaseController {

    /**
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * FractalManager
     */
    protected $fractal;

    public function __construct(
        CategoryRepository $categoryRepository,
        FractalManager $fractal
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->fractal = $fractal;
    }

    public function getIndex($categoryId) {

        $category = $this->categoryRepository->findById($categoryId);

        $resource = new Collection([$category],new CategoryTransformer());

        $data = $this->fractal->createData($resource)->toArray();
        return response()->json($data); // or return it in a Response

    }

}