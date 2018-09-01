<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\Notifications;
use Illuminate\Http\Request;

class AdminNotificationController extends ResourceController
{
    public function __construct()
    {
        $model = new Notifications();
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        $request['created_by'] = fire_auth()->user()->id;
        $request['read'] = 0;
        $resource = $this->model->create($request->all());

        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return redirect()->route($this->model->getRouteName() . '.index');
    }

    public function read(Notification $notification)
    {
        $this->authorize('owner', $notification);
        $notification->update(['read' => 1]);
    }

}
