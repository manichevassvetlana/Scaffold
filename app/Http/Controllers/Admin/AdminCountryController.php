<?php

namespace App\Http\Controllers\Admin;

use App\Countries;
use App\Http\Controllers\ResourceController;

class AdminCountryController extends ResourceController
{

    public function __construct()
    {
        $model = new Countries();
        parent::__construct($model);
    }

    public function findByCode($code){
        $country = Countries::where('alpha_2_code', $code)->first();
        return response()->json([$country]);
    }

}
