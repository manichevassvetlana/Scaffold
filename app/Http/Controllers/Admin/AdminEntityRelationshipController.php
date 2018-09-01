<?php

namespace App\Http\Controllers\Admin;

use App\EntityRelationships;
use App\Http\Controllers\ResourceController;
use Illuminate\Http\Request;

class AdminEntityRelationshipController extends ResourceController
{
    public function __construct()
    {
        $model = new EntityRelationships();
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        if($request->starts_at > $request->ends_at && $request->ends_at) return back()->with('error', "'Starts at' can not be after 'ends at'");
        $resource = $this->model->create($request->all());

        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return redirect()->route('entity-relationships.index');
    }

    public function update(Request $request, $id)
    {
        if($request->starts_at > $request->ends_at && $request->ends_at) return back()->with('error', "'Starts at' can not be after 'ends at'");
        $resource = $this->model->findOrFail($id);
        $resource->update($request->all());

        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return back()->with('success', $resource->getModelName().'updated successfully.');
    }
}
