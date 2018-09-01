<?php

namespace App\Http\Controllers\Admin;

use App\Cities;
use App\Http\Controllers\ResourceController;

class AdminCityController extends ResourceController
{
    protected $resource;


    public function __construct()
    {
        $model = new Cities();
        parent::__construct($model);
    }

}
