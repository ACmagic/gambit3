<?php

namespace Modules\Catalog\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AbstractBaseController;
use Modules\Catalog\Repositories\LineRepository;

class LineController extends AbstractBaseController
{

    protected $lineRepository;

    /**
     * Create a new authentication controller instance.
     *
     * @param LineRepository $lineRepository
     *   The line repository.
     */
    public function __construct(LineRepository $lineRepository)
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->lineRepository = $lineRepository;

        // middleware to require login

    }

    public function getIndex() {

        //$sites = $this->siteRepository->findAll();

        return view('catalog::admin.line.index');

    }

}