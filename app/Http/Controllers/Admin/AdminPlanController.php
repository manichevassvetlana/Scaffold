<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\Plan;
use App\Plans;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminPlanController extends ResourceController
{
    public function __construct()
    {
        $model = new Plans();
        parent::__construct($model);
    }

}