<?php

namespace Modules\Event\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AbstractBaseController;
use Modules\Event\Repositories\CompetitorRepository;
use Doctrine\ORM\EntityManagerInterface;

class CompetitorController extends AbstractBaseController
{

    protected $competitorRepository;
    protected $em;

    /**
     * Create a new authentication controller instance.
     *
     * @param CompetitorRepository $competitorRepository
     *   The accepted line repository.
     */
    public function __construct(CompetitorRepository $competitorRepository, EntityManagerInterface $em)
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->competitorRepository = $competitorRepository;
        $this->em = $em;

        // middleware to require login

    }

    public function getIndex() {

        $competitors = $this->competitorRepository->findAll();

        return view('event::admin.competitor.index',['competitors'=>$competitors]);

    }

}