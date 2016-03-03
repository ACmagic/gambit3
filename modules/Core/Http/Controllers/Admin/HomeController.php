<?php

namespace Modules\Core\Http\Controllers\Admin;

class HomeController extends AbstractBaseController
{

    public function getIndex() {
        return view('core::admin.home.index');
    }

}