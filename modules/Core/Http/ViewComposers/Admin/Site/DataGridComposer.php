<?php namespace Modules\Core\Http\ViewComposers\Admin\Site;

use Illuminate\View\View;
use Doctrine\ORM\EntityManagerInterface;
use Mesour\Bridges\Laravel\ApplicationManager;
use Mesour\UI\DataGrid;

class DataGridComposer {

    protected $em;
    protected $uiApp;

    public function __construct(EntityManagerInterface $em,ApplicationManager $uiApp) {

        $this->em = $em;
        $this->uiApp = $uiApp;

    }

    public function compose(View $view) {

        $source = new DataGridSource($this->em);

        $grid = new DataGrid('sites',$this->uiApp->getApplication());
        $grid->setSource($source);
        $grid->enablePager(10);
        $grid->enableFilter(true);

        $grid->addText('id','ID');
        $grid->addText('machineName','Machine Name');

        $grid->addText('creator','Creator')->setFiltering(false)->setOrdering(false)->setCallback(function($col,$site) {
            return $site->getCreator()->getEmail();
        });

        $grid->addDate('createdAt','Created');
        $grid->addDate('updatedAt','Updated');

        $view->with('grid',$grid);

    }

}