<?php

namespace Modules\Catalog\Routing\Matching;

use Illuminate\Routing\Matching\ValidatorInterface;
use Illuminate\Routing\Route;
use Illuminate\Http\Request;
use Modules\Event\Repositories\CategoryRepository;

class CategoryValidator implements ValidatorInterface
{

    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Validate a given rule against a route and request.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function matches(Route $route, Request $request)
    {
        $path = $request->path() == '/' ? '/' : '/'.$request->path();
        $category = $this->categoryRepository->findOneByHierarchicalPath($path);
        return $category?true:false;
    }
}