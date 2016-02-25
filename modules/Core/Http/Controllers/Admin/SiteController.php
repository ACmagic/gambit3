<?php

namespace Modules\Core\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Doctrine\ORM\EntityManagerInterface;

class SiteController extends Controller
{

    protected $em;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(EntityManagerInterface $em)
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->em = $em;

        // middleware to require login

    }

    public function getList() {

        $site = $this->em->find('Modules\Core\Entities\Site',1);
        $site->getCreator()->getEmail();

        return view('core::admin.site.list',['site'=>$site]);

    }

}
