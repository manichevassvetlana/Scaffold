<?php

namespace App\Http\Controllers\Admin;

use App\Apis;
use App\Http\Controllers\ResourceController;
use App\LookupValues;
use Illuminate\Http\Request;

class AdminAPIController extends ResourceController
{
    public function __construct()
    {
        $model = new Apis();
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        $request['type'] = $request->type_api;
        ($request->has('deprecated') && $request->deprecated == 'on') ? $request['deprecated'] = 1 : $request['deprecated'] = 0;
        $resource = $this->model->create($request->all());

        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return redirect()->route($this->model->getRouteName().'.index');
    }

    public function update(Request $request, $id)
    {
        $request['type'] = $request->type_api;
        ($request->has('deprecated') && $request->deprecated == 'on') ? $request['deprecated'] = 1 : $request['deprecated'] = 0;
        $resource = $this->model->findOrFail($id);
        $resource->update($request->all());

        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return back()->with('success', $resource->getModelName().' updated successfully.');
    }

    public function show($id, Request $request)
    {

        $api_types = [];

        if($request->has('q')) {
            $search = trim($request->q);
            $api_types = LookupValues::where("value", $search)->where("type", "API_TYPE")->get();
        }

        return response()->json($api_types);

    }
    
}
