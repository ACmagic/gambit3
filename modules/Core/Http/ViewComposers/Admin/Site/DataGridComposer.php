<?php namespace Modules\Core\Http\ViewComposers\Admin\Site;

use Illuminate\View\View;
use Doctrine\ORM\EntityManagerInterface;
use Mesour\Bridges\Laravel\ApplicationManager;
use Mesour\UI\DataGrid;

class DataGridComposer {

    protected $uiApp;

    public function __construct(ApplicationManager $uiApp) {

        $this->uiApp = $uiApp;

    }

    public function compose(View $view) {

        $source = new DataGridSource();

        $grid = new DataGrid('sites',$this->uiApp->getApplication());
        $grid->setSource($source);
        $grid->enablePager(10);
        $grid->enableFilter(true);

        $grid->addText('id','ID');
        $grid->addText('machineName','Machine Name');

        $grid->addText('creator','Creator')->setFiltering(false)->setOrdering(false)->setCallback(function($col,$site) {
            return $site['creator']['email'];
        });

        $grid->addDate('createdAt','Created');
        $grid->addDate('updatedAt','Updated');

        $view->with('grid',$grid);

    }

}