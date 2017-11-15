<?php

namespace Modules\Core\Http\Controllers\Admin;

class PassportController extends AbstractBaseController
{

    public function getIndex() {

        return view('core::admin.passport.index');

    }

}
