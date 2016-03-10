<?php namespace Modules\Catalog\Http\ViewComposers\Admin\Line;

use Illuminate\View\View;
use Modules\Catalog\Repositories\LineRepository;

class DataGridComposer {

    protected $lineRepository;

    public function __construct(LineRepository $lineRepository) {

        $this->lineRepository = $lineRepository;

    }

    public function compose(View $view) {

        $lines = $this->lineRepository->findAll();
        $view->with('lines',$lines);

    }

}