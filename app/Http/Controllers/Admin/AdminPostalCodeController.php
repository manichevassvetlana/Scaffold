<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\PostalCodes;

class AdminPostalCodeController extends ResourceController
{
    public function __construct()
    {
        $model = new PostalCodes();
        $role = 'admin';
        parent::__construct($model, $role);
    }

}
