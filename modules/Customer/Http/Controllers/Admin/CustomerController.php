<?php

namespace Modules\Customer\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
//use Modules\Core\Repositories\StoreRepository;

class CustomerController extends Controller
{

    //protected $storeRepository;

    /**
     * Create a new authentication controller instance.
     *
     * @param StoreRepository $storeRepository
     *   The store repository.
     *
     * @return void
     */
    /*public function __construct(StoreRepository $storeRepository)
    {
        //$this->middleware('guest', ['except' => 'logout']);
        $this->storeRepository = $storeRepository;

        // middleware to require login

    }*/

    public function getIndex() {

        //$user = $this->em->find('Modules\Core\Entities\User',1);

        return view('customer::admin.customer.index');

    }

}
