<?php namespace Modules\Core\Http\ViewComposers\Admin\User;

use Illuminate\View\View;
use Doctrine\ORM\EntityManagerInterface;
use Mesour\UI\DataGrid;
use Mesour\Bridges\Laravel\ApplicationManager;

class DataGridComposer {

    protected $em;
    protected $uiApp;

    public function __construct(EntityManagerInterface $em,ApplicationManager $uiApp) {

        $this->em = $em;
        $this->uiApp = $uiApp;

    }

    public function compose(View $view) {

        $source = new DataGridSource($this->em);

        $grid = new DataGrid('users',$this->uiApp->getApplication());
        $grid->setSource($source);
        $grid->addText('id','ID');
        $grid->addText('email','Email');
        $grid->addDate('createdAt','Created');
        $grid->addDate('updatedAt','Updated');

        $view->with('grid',$grid);

    }

}