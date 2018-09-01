<?php

namespace App\Http\Controllers\Admin;

use App\Counties;
use App\Http\Controllers\ResourceController;

class AdminCountyController extends ResourceController
{
    public function __construct()
    {
        $model = new Counties();
        parent::__construct($model);
    }
}
