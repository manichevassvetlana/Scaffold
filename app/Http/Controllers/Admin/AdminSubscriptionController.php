<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\Subscription;
use App\Subscriptions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSubscriptionController extends ResourceController
{
    public function __construct()
    {
        $model = new Subscriptions();
        $role = 'admin';
        parent::__construct($model, $role);
    }
}
