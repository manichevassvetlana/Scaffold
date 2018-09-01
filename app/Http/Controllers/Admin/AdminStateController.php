<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\States;

class AdminStateController extends ResourceController
{
    public function __construct()
    {
        $model = new States();
        parent::__construct($model);
    }

}
