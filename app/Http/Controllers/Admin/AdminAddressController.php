<?php

namespace App\Http\Controllers\Admin;

use App\Addresses;
use App\Http\Controllers\ResourceController;

class AdminAddressController extends ResourceController
{
    public function __construct()
    {
        $model = new Addresses();
        parent::__construct($model);
    }

}
