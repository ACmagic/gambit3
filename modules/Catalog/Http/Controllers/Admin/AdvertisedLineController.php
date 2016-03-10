<?php

namespace Modules\Catalog\Http\Controllers\Admin;

use Modules\Core\Http\Controllers\Admin\AbstractBaseController;
use Modules\Catalog\Repositories\AdvertisedLineRepository;

class AdvertisedLineController extends AbstractBaseController
{

    protected $advertisedLineRepository;

    /**
     * Create a new authentication controller instance.
     *
     * @param AdvertisedLineRepository $advertisedLineRepository
     *   The advertised line repository.
     */
    public function __construct(AdvertisedLineRepository $advertisedLineRepository)
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->advertisedLineRepository = $advertisedLineRepository;

        // middleware to require login

    }

    public function getIndex() {

        //$sites = $this->siteRepository->findAll();

        return view('catalog::admin.advertised_line.index');

    }

}