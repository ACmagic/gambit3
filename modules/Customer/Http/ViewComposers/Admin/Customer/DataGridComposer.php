<?php namespace Modules\Customer\Http\ViewComposers\Admin\Customer;

use Illuminate\View\View;
use Mesour\UI\DataGrid;
use Mesour\Bridges\Laravel\ApplicationManager;
use Doctrine\ORM\EntityManagerInterface;

class DataGridComposer {

    protected $em;
    protected $uiApp;

    public function __construct(EntityManagerInterface $em,ApplicationManager $uiApp) {

        $this->em = $em;
        $this->uiApp = $uiApp;

    }

    public function compose(View $view) {

        $source = new DataGridSource($this->em);

        $grid = new DataGrid('customers',$this->uiApp->getApplication());
        $grid->setSource($source);
        $grid->enablePager(1);
        $grid->enableFilter(true);

        $grid->addText('id','ID');
        $grid->addText('site','Site')->setFiltering(false)->setOrdering(false)->setCallback(function($col,$customer) {
            return $customer->getPool()->getSite()->getMachineName();
        });
        $grid->addText('email','Email');
        $grid->addDate('createdAt','Created');
        $grid->addDate('updatedAt','Updated');

        $view->with('grid',$grid);

    }

}