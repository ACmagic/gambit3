<?php

namespace Modules\Catalog\Http\Controllers\Frontend;

use Modules\Core\Http\Controllers\Frontend\AbstractBaseController;
use Modules\Catalog\Repositories\InverseLineRepository;

class LineController extends AbstractBaseController
{

    protected $inverseLineRepository;

    /**
     * Create a new authentication controller instance.
     *
     * @param InverseLineRepository $inverseLineRepository
     *   The advertised line repository.
     */
    public function __construct(InverseLineRepository $inverseLineRepository)
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->inverseLineRepository = $inverseLineRepository;

        // middleware to require login

    }

    public function getIndex() {

        //$sites = $this->siteRepository->findAll();

        $lines = $this->inverseLineRepository->findAllStoresOpenLines();

        return view('catalog::frontend.line.index',['lines'=>$lines]);

    }

}