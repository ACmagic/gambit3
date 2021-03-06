<?php namespace Modules\Catalog\Http\ViewComposers\Admin\Line;

use Illuminate\View\View;
use Modules\Catalog\Repositories\LineRepository;
use Mesour\DataGrid\Sources\DoctrineGridSource;
use Mesour\Bridges\Laravel\ApplicationManager;
use Mesour\UI\DataGrid;

class DataGridComposer {

    protected $lineRepository;
    protected $uiApp;

    public function __construct(LineRepository $lineRepository,ApplicationManager $uiApp) {

        $this->lineRepository = $lineRepository;
        $this->uiApp = $uiApp;

    }

    public function compose(View $view) {

        $qb = $this->lineRepository->createQueryBuilderForAdminDataGrid();
        $source = new DoctrineGridSource($qb);
        $source->setPrimaryKey('id');
        //$source->setReference('store',StoreEntity::class, 'machineName');

        $grid = new DataGrid('lines',$this->uiApp->getApplication());
        $grid->setSource($source);
        $grid->addText('id','ID');

        $grid->addText('store','Store')
            ->setFiltering(false)
            ->setOrdering(false)
            ->setCallback(function($col,$line) {
                return $line->getStore()->getMachineName();
            });

        $grid->addText('odds','Odds');

        $view->with('grid',$grid);

    }

}