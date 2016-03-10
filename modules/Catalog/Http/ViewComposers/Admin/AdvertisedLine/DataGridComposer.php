<?php namespace Modules\Catalog\Http\ViewComposers\Admin\AdvertisedLine;

use Illuminate\View\View;
use Modules\Catalog\Repositories\AdvertisedLineRepository;

class DataGridComposer {

    protected $advertisedLineRepository;

    public function __construct(AdvertisedLineRepository $advertisedLineRepository) {

        $this->advertisedLineRepository = $advertisedLineRepository;

    }

    public function compose(View $view) {

        $advertisedLines = $this->advertisedLineRepository->findAll();
        $view->with('advertisedLines',$advertisedLines);

    }

}