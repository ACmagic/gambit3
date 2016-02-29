<?php namespace Modules\Core\Http\ViewComposers\Admin\Site;

use Illuminate\View\View;
use Modules\Core\Repositories\SiteRepository;

class DataGridComposer {

    protected $siteRepository;

    public function __construct(SiteRepository $siteRepository) {

        $this->siteRepository = $siteRepository;

    }

    public function compose(View $view) {

        $sites = $this->siteRepository->findAll();
        $view->with('sites',$sites);

    }

}