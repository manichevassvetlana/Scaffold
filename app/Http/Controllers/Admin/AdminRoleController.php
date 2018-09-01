<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\Roles;

class AdminRoleController extends ResourceController
{
    public function __construct()
    {
        $model = new Roles();
        $role = 'admin';
        parent::__construct($model, $role);
    }
}
