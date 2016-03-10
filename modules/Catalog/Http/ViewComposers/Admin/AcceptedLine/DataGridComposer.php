<?php namespace Modules\Catalog\Http\ViewComposers\Admin\AcceptedLine;

use Illuminate\View\View;
use Modules\Catalog\Repositories\AcceptedLineRepository;

class DataGridComposer {

    protected $acceptedLineRepository;

    public function __construct(AcceptedLineRepository $acceptedLineRepository) {

        $this->acceptedLineRepository = $acceptedLineRepository;

    }

    public function compose(View $view) {

        $acceptedLines = $this->acceptedLineRepository->findAll();
        $view->with('acceptedLines',$acceptedLines);

    }

}