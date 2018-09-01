<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\FileController;
use App\Http\Controllers\ResourceController;
use App\LookupValues;
use App\Pages;
use App\Users;
use Illuminate\Http\Request;

class AdminPageController extends ResourceController
{
    public function __construct()
    {
        $model = new Pages();
        $role = 'admin';
        parent::__construct($model, $role);
    }

    public function store(Request $request)
    {
        if (Pages::where('slug', $request->slug)->exists()) return back()->with('error', 'You already have page with this slug. Delete an existing page to create a new one.');

        $request["user_id"] = fire_auth()->user()->id;
        $request["created_by"] = fire_auth()->user()->id;

        $versions = $request->versions;
        $versions['layout'] = LookupValues::findOrFail($request->layout);
        $versions['type'] = LookupValues::findOrFail($request->type);
        $versions['author'] = Users::findOrFail($request->user_id);
        $versions['image'] = null;
        $versions['updated_by'] = fire_auth()->user();
        $versions['updated_at'] = (new \DateTime('now'))->format('Y-m-d');
        $fill = $request->only(['slug', 'created_by', 'status']);
        $fill['versions'] = [0 => $versions];
        $fill['version_id'] = 0;
        $page = Pages::create($fill);

        if(request()->is('api/*')){
            return response()->json(['status' => 'Resource was created successfully']);
        }

        return redirect()->route($this->model->getRouteName() . '.index');
    }

    public function update(Request $request, $id)
    {
        $page = $this->model->findOrFail($id);
        if($request->slug != $page->slug && Pages::where('slug', $request->slug)->exists()) return back()->with('error', 'You already have page with this slug. Delete an existing page to create a new one.');

        $request["created_by"] = fire_auth()->user()->id;

        $page->update($request->only(['slug', 'status', 'created_by']));

        $pageId = $page->version_id;
        $versions = $request->versions;
        $versions['layout'] = LookupValues::findOrFail($request->layout);
        $versions['type'] = LookupValues::findOrFail($request->type);
        $versions['author'] = Users::findOrFail($request->user_id);
        $versions['image'] = null;
        $versions['updated_by'] = fire_auth()->user();
        $versions['updated_at'] = (new \DateTime('now'))->format('Y-m-d');
        $pageVersions = $page->versions;
        if($page->getRelatedName('status') == 'Published') {
            $key = count($pageVersions);
            $pageVersions[$key] = $versions;
            $page->update(['versions' => $pageVersions, 'version_id' => $key]);
        }
        else{
            $pageVersions[$pageId] = $versions;
            $page->update(['versions' => $pageVersions]);
        }

        if(request()->is('api/*')){
            return response()->json(['status' => 'Resource was updated successfully']);
        }

        return back()->with('success', $page->getModelName().' updated successfully.');
    }

    private function storeImage($request, $resource)
    {
        if($request->hasFile('image') && $request->file('image')){
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $image = $request->file('image');
            if(!is_null($resource->image)) FileController::remove($resource->image);
            $path = FileController::store($image);
            $resource->image = $path;
            $resource->save();
        }
    }

    public function updateVersion($page, Request $request)
    {
        Pages::findOrFail($page)->update(['version_id' => $request->version]);
    }

}
