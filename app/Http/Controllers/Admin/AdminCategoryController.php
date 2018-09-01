<?php

namespace App\Http\Controllers\Admin;

use App\Categories;
use App\Http\Controllers\ResourceController;
use App\LookupValues;
use Illuminate\Http\Request;

class AdminCategoryController extends ResourceController
{
    public function __construct()
    {
        $model = new Categories();
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        $request['type'] = $request->type_category;
        $resource = $this->model->create($request->all());

        if (request()->is('api/*')) {
            return $resource->toJson();
        }

        return redirect()->route($this->model->getRouteName() . '.index');
    }

    public function update(Request $request, $id)
    {
        $request['type'] = $request->type_category;
        $resource = $this->model->findOrFail($id);
        $resource->update($request->all());

        if (request()->is('api/*')) {
            return $resource->toJson();
        }

        return back()->with('success', $resource->getModelName() . ' updated successfully.');
    }

    public function show($id, Request $request)
    {
        if ($id === 'find') {
            $categories = [];

            if ($request->has('q')) {

                $search = trim($request->q);
                $categories = Categories::where('name', 'like', $search)->get();
            }

            return response()->json($categories);
        } else if ($id === 'types') {
            $category_types = [];

            if ($request->has('q')) {
                $search = trim($request->q);
                $category_types = (new LookupValues())
                    ->select(['value'])
                    ->where("type", "=", "CATEGORY_TYPE")
                    ->where("value", '=', $search)
                    ->get();
            }

            return response()->json($category_types);
        }

    }

}