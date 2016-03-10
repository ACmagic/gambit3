<?php

namespace Modules\Catalog\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AbstractBaseController;
use Modules\Catalog\Repositories\AcceptedLineRepository;

class AcceptedLineController extends AbstractBaseController
{

    protected $acceptedLineRepository;

    /**
     * Create a new authentication controller instance.
     *
     * @param AcceptedLineRepository $acceptedLineRepository
     *   The accepted line repository.
     */
    public function __construct(AcceptedLineRepository $acceptedLineRepository)
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->acceptedLineRepository = $acceptedLineRepository;

        // middleware to require login

    }

    public function getIndex() {

        //$sites = $this->siteRepository->findAll();

        return view('catalog::admin.accepted_line.index');

    }

}