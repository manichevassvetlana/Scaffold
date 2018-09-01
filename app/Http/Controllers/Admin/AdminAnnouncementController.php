<?php

namespace App\Http\Controllers\Admin;

use App\Announcements;
use App\Authorize;
use App\Events\AnnouncementCreate;
use App\Http\Controllers\ResourceController;
use Illuminate\Http\Request;
use WebsolutionsGroup\Firestore\DocumentSnapshot;

class AdminAnnouncementController extends ResourceController
{
    public function __construct()
    {
        $model = new Announcements();
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        $request['read'] = false;
        $resource = $this->model->create($request->all());

        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return redirect()->route($this->model->getRouteName() . '.index');
    }

    public function update(Request $request, $id)
    {
        $request['read'] = false;
        $resource = $this->model->findOrFail($id);
        $resource->update($request->all());
        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return back()->with('success', $resource->getModelName().' updated successfully.');
    }

    public function read($announcement)
    {
        $announcement = $announcement instanceof DocumentSnapshot ? $announcement : Announcements::findOrFail($announcement);
        Authorize::owner($announcement);
        $announcement->update(['read' => true]);
    }

    public function announcement($announcement)
    {
        $announcement = Announcements::findOrFail($announcement);
        $this->read($announcement);
        if(request()->is('api/*')){
            return $announcement->toJson();
        }
        return view('admin._resources.viewResource', ['resource' => $announcement]);
    }

}
