<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\Locations;
use Google\Cloud\Core\GeoPoint;
use Illuminate\Http\Request;

class AdminLocationController extends ResourceController
{
    public function __construct()
    {
        $model = new Locations();
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        if(!is_null($request['lat']) && !is_null($request['lng'])){
            $resource = $this->model->create(['description' => $request->description, 'name' => $request->name, 'position' => new GeoPoint($request['lat'], $request['lng']), 'country_id' => $request->country_id]);
        }
        else {
            $request['position'] = null;
            $resource = $this->model->create($request->except('lat', 'lng'));
        }

        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return redirect()->route($this->model->getRouteName().'.index');
    }

    public function update(Request $request, $id)
    {
        $resource = $this->model->findOrFail($id);

        if(!is_null($request['lat']) && !is_null($request['lng'])){
            $resource->update(['description' => $request->description, 'name' => $request->name, 'position' => new GeoPoint($request['lat'], $request['lng']), 'country_id' => $request->country_id]);
        }
        else {
            $request['position'] = null;
            $resource->update($request->except('lat', 'lng'));
        }


        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return back()->with('success', $resource->getModelName().' updated successfully.');
    }

}
