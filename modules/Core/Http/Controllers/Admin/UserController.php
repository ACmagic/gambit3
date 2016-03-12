<?php

namespace Modules\Core\Http\Controllers\Admin;

use Modules\Core\Repositories\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Mesour\DataGrid\Sources\DoctrineGridSource;
use Mesour\UI\DataGrid;
use Modules\Core\Entities\User as UserEntity;
use Mesour\Components\Application\IApplication;

class UserController extends AbstractBaseController
{

    protected $userRepository;
    protected $em;
    protected $uiApp;

    /**
     * Create a new authentication controller instance.
     *
     * @param UserRepository $userRepository
     *   The user repository.
     *
     * @param EntityManagerInterface $em
     *   The entity manager.
     *
     * @param IApplication $uiApp
     *   The ui application.
     */
    public function __construct(UserRepository $userRepository,EntityManagerInterface $em,IApplication $uiApp)
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->userRepository = $userRepository;
        $this->em = $em;
        $this->uiApp = $uiApp;

        // middleware to require login

    }

    public function getIndex() {

        //$user = $this->em->find('Modules\Core\Entities\User',1);

        $qb = $this->em->createQueryBuilder();
        $qb
            ->select('u')
            ->from(UserEntity::class,'u');

        $source = new DoctrineGridSource($qb,[
            'id'=> 'u.id'
        ]);

        $source->setPrimaryKey('id');

        $grid = new DataGrid('users',$this->uiApp);
        $grid->setSource($source);
        $grid->addText('id','ID');
        $grid->addText('email','Email');

        return view('core::admin.user.index',['grid'=>$grid]);

    }

}
