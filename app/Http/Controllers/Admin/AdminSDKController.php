<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\Sdks;
use Illuminate\Http\Request;

class AdminSDKController extends ResourceController
{
    public function __construct()
    {
        $model = new Sdks();
        $role = 'admin';
        parent::__construct($model, $role);
    }

    public function store(Request $request)
    {
        $request['type'] = $request->type_sdk;
        $resource = $this->model->create($request->all());

        if(request()->is('api/*')){
            return response()->json(['status' => 'Resource was created successfully']);
        }

        return redirect()->route($this->model->getRouteName().'.index');
    }

    public function update(Request $request, $id)
    {
        $request['type'] = $request->type_sdk;
        $resource = $this->model->findOrFail($id);
        $resource->update($request->all());

        if(request()->is('api/*')){
            return response()->json(['status' => 'Resource was updated successfully']);
        }

        return back()->with('success', $resource->getModelName().' updated successfully.');
    }
    
}
