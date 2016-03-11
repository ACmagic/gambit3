<?php

namespace Modules\Event\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AbstractBaseController;
use Modules\Event\Repositories\CategoryRepository;
use Modules\Event\Entities\Category as CategoryEntity;
use Doctrine\ORM\EntityManagerInterface;
use Carbon\Carbon;

class CategoryController extends AbstractBaseController
{

    protected $categoryRepository;
    protected $em;

    /**
     * Create a new authentication controller instance.
     *
     * @param CategoryRepository $categoryRepository
     *   The accepted line repository.
     */
    public function __construct(CategoryRepository $categoryRepository, EntityManagerInterface $em)
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->categoryRepository = $categoryRepository;
        $this->em = $em;

        // middleware to require login

    }

    public function getIndex() {

        $category = new CategoryEntity();
        $category->setMachineName('a');
        $category->setHumanName('b');
        $category->setCreatedAt(Carbon::now());
        $category->setUpdatedAt(Carbon::now());

        $node = $this->categoryRepository->findByMachineName('x');
        //dump($node);

        $category->setParent($node);

        //$this->em->persist($category);
        //$this->em->flush();

        //$sites = $this->siteRepository->findAll();

        //return view('catalog::admin.accepted_line.index');

    }

}