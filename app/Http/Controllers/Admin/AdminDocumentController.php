<?php

namespace App\Http\Controllers\Admin;

use App\Documents;
use App\EntityRelationships;
use App\Http\Controllers\ResourceController;
use Illuminate\Http\Request;

class AdminDocumentController extends ResourceController
{
    public function __construct()
    {
        $model = new Documents();
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        $request['reference_type'] = EntityRelationships::findOrFail($request->reference_type)->path;
        $resource = $this->model->create($request->all());

        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return redirect()->route($this->model->getRouteName().'.index');
    }

    public function update(Request $request, $id)
    {
        $request['reference_type'] = EntityRelationships::findOrFail($request->reference_type)->path;
        $resource = $this->model->findOrFail($id);
        $resource->update($request->all());

        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return back()->with('success', $resource->getModelName().' updated successfully.');
    }

    public function show($id, Request $request) {
        $entity = EntityRelationships::findOrFail($id);
        $reference = $entity->getReference();
        return response()->json(['references' => $reference->all(), 'field' => $reference->searchField]);
    }

}
