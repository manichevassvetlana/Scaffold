<?php

namespace App\Http\Controllers\Admin;

use App\Abilities;
use App\Http\Controllers\ResourceController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminAbilityController extends ResourceController
{
    public function __construct()
    {
        $model = new Abilities();
        parent::__construct($model);
    }

}