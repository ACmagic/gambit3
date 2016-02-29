<?php

namespace Modules\Core\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Core\Repositories\SiteRepository;

class SiteController extends Controller
{

    protected $siteRepository;

    /**
     * Create a new authentication controller instance.
     *
     * @param SiteRepository $siteRepository
     *   The site repository.
     */
    public function __construct(SiteRepository $siteRepository)
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->siteRepository = $siteRepository;

        // middleware to require login

    }

    public function getIndex() {

        //$sites = $this->siteRepository->findAll();

        return view('core::admin.site.index');

    }

}