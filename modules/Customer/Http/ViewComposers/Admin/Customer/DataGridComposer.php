<?php namespace Modules\Customer\Http\ViewComposers\Admin\Customer;

use Illuminate\View\View;
use Modules\Customer\Repositories\CustomerRepository;

class DataGridComposer {

    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository) {

        $this->customerRepository = $customerRepository;

    }

    public function compose(View $view) {

        $customers = $this->customerRepository->findAll();
        $view->with('customers',$customers);

    }

}