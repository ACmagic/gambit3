<?php namespace Modules\Core\Http\ViewComposers\Admin\User;

use Illuminate\View\View;
use Modules\Core\Repositories\UserRepository;

class DataGridComposer {

    protected $userRepository;

    public function __construct(UserRepository $userRepository) {

        $this->userRepository = $userRepository;

    }

    public function compose(View $view) {

        $sites = $this->userRepository->findAll();
        $view->with('users',$sites);

    }

}