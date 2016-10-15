<?php namespace Modules\Catalog\Routing;

use Illuminate\Routing\Route as BaseRoute;
use Modules\Catalog\Routing\Matching\CategoryValidator;
use Illuminate\Routing\Matching\MethodValidator;
use Illuminate\Routing\Matching\SchemeValidator;
use Illuminate\Routing\Matching\HostValidator;
use Illuminate\Http\Request;
use Modules\Event\Repositories\CategoryRepository;
use Illuminate\Routing\ControllerDispatcher;

/**
 * Special dynamic touting for catalog categories.
 */
class CategoryRoute extends BaseRoute {

    protected $validatorOverrides;

    /**
     * @param CategoryRepository
     */
    protected $categoryRepository;

    /**
     * Create a new Route instance.
     *
     * @param CategoryRepository $categoryRepository
     *   The category repository.
     */
    public function __construct(CategoryRepository $categoryRepository)
    {

        $this->categoryRepository = $categoryRepository;

        $action = [
            'uses'=> function() use ($categoryRepository) {
                $path = app('request')->path();
                $category = $categoryRepository->findOneByHierarchicalPath($path);
                $controller = app()->make('Modules\Catalog\Http\Controllers\Frontend\CategoryController');
                return $controller->callAction('getIndex', ['categoryId'=>$category->getId()]);
            }
        ];

        $action['uses']->bindTo($this);

        parent::__construct(['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE'],'_catalog_category',$action);

    }

    /**
     * Determine if the route matches given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  bool  $includingMethod
     * @return bool
     */
    public function matches(Request $request, $includingMethod = true)
    {
        $this->compileRoute();

        $validators = $this->getValidatorOverrides();

        foreach ($validators as $validator) {
            /*if (! $includingMethod && $validator instanceof MethodValidator) {
                continue;
            }*/

            if (! $validator->matches($this, $request)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the route validators for the instance.
     *
     * @return array
     */
    public function getValidatorOverrides()
    {
        if (isset($this->validatorOverrides)) {
            return $this->validatorOverrides;
        }

        $this->validatorOverrides = [
            new MethodValidator, new SchemeValidator,
            new HostValidator, /*new UriValidator,*/
            new CategoryValidator($this->categoryRepository)
        ];

        return $this->validatorOverrides;
    }

}