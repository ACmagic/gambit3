<?php namespace Modules\Core\Http\ViewComposers\Admin\User;

use Illuminate\View\View;
use Modules\Core\Repositories\UserRepository;
use Mesour\DataGrid\Sources\DoctrineGridSource;
use Mesour\UI\DataGrid;
use Mesour\Components\Application\IApplication;

class DataGridComposer {

    protected $userRepository;
    protected $uiApp;

    public function __construct(UserRepository $userRepository,IApplication $uiApp) {

        $this->userRepository = $userRepository;
        $this->uiApp = $uiApp;

    }

    public function compose(View $view) {

        $qb = $this->userRepository->createQueryBuilderForAdminDataGrid();
        $source = new DoctrineGridSource($qb);
        $source->setPrimaryKey('id');

        $grid = new DataGrid('users',$this->uiApp);
        $grid->setSource($source);
        $grid->addText('id','ID');
        $grid->addText('email','Email');
        $grid->addDate('createdAt','Created');
        $grid->addDate('updatedAt','Updated');

        $view->with('grid',$grid);

    }

}