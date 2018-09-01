<?php

namespace App\Http\Controllers\Admin;

use App\Developers;
use App\Http\Controllers\ResourceController;
use Illuminate\Http\Request;

class AdminDeveloperController extends ResourceController
{
    public function __construct()
    {
        $model = new Developers();
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        ($request->has('personal_use') && $request->personal_use == 'on') ? $request['personal_use'] = 1 : $request['personal_use'] = 0;
        ($request->has('business_use') && $request->personal_use == 'on') ? $request['business_use'] = 1 : $request['business_use'] = 0;
        $resource = $this->model->create($request->all());

        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return redirect()->route($this->model->getRouteName().'.index');
    }

    public function update(Request $request, $id)
    {
        ($request->has('personal_use') && $request->personal_use == 'on') ? $request['personal_use'] = 1 : $request['personal_use'] = 0;
        ($request->has('business_use') && $request->business_use == 'on') ? $request['business_use'] = 1 : $request['business_use'] = 0;
        $resource = $this->model->findOrFail($id);
        $resource->update($request->all());

        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return back()->with('success', $resource->getModelName().' updated successfully.');
    }

}
