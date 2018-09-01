<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\Repositories;
use Illuminate\Http\Request;

class AdminRepositoryController extends ResourceController
{
    public function __construct()
    {
        $model = new Repositories();
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        $request['type'] = $request->type_repository;
        $resource = $this->model->create($request->all());

        if(request()->is('api/*')){
            return response()->json(['status' => 'Resource was created successfully']);
        }

        return redirect()->route($this->model->getRouteName().'.index');
    }

    public function update(Request $request, $id)
    {
        $request['type'] = $request->type_repository;
        $resource = $this->model->findOrFail($id);
        $resource->update($request->all());

        if(request()->is('api/*')){
            return response()->json(['status' => 'Resource was updated successfully']);
        }

        return back()->with('success', $resource->getModelName().' updated successfully.');
    }
    
}
