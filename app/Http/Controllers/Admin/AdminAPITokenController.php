<?php

namespace App\Http\Controllers\Admin;

use App\APIToken;
use App\Http\Controllers\ResourceController;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminAPITokenController extends ResourceController
{
    public function __construct()
    {
        $model = new APIToken();
        $role = 'admin';
        parent::__construct($model, $role);
    }

    public function store(Request $request)
    {
        ($request->has('transient') && $request->transient == 'on') ? $request['transient'] = 1 : $request['transient'] = 0;
        $resource = $this->model->create($request->all());

        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return redirect()->route($this->model->getRouteName().'.index');
    }

    public function update(Request $request, $id)
    {
        ($request->has('transient') && $request->transient == 'on') ? $request['transient'] = 1 : $request['transient'] = 0;
        $resource = $this->model->findOrFail($id);
        $resource->update($request->all());

        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return back()->with('success', $resource->getModelName().' updated successfully.');
    }
    
}
