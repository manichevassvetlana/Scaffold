<?php

namespace App\Http\Controllers;

use App\Document;
use App\EntityRelationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ResourceController extends Controller
{
    public $model;
    public $role = 'admin';

    public function __construct($model, $role = null) {
        $this->model = $model;
        is_null($role) ? '' : $this->role = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resource = new $this->model;
        $count = request('count') ?? 10;
        $page = request('start_at') ?? false;
        $search = request('search') ?? false;
        $resources = $resource;
        if($search) $resources = $resource->where($this->model->searchField, 'like', $search)->get();
        else !$page ? $resources = $resources->paginate($count) : $resources = $resources->paginate($count, $page);

        $length = count($resources);
        if($length > 0) $page = $resources[$length - 1][$this->model->searchField];

        $length < $count ? $length = false : $length = true;

        if(request()->is('api/*')){
            return $resources->toJson();
        }

        $countArray = [10, 25, 50, 100];
        return view($this->role.'._resources.resources', compact('resource', 'resources', 'count', 'page', 'countArray', 'search', 'length'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resource = new $this->model;
        if(request()->is('api/*')){
            return $resource->toJson();
        }
        return view($this->role.'._resources.createResource', compact('resource'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ($request->has('active') && $request->active == 'on') ? $request['active'] = 1 : $request['active'] = 0;
        $resource = $this->model->create($request->all());
        if(request()->is('api/*')){
            return $resource->toJson();
        }
        return redirect()->route($this->model->getRouteName().'.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resource = $this->model->findOrFail($id);
        if(request()->is('api/*')){
            return $resource->toJson();
        }
        return view($this->role.'._resources.editResource', compact('resource'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        ($request->has('active') && $request->active == 'on') ? $request['active'] = 1 : $request['active'] = 0;
        $resource = $this->model->findOrFail($id);
        $resource->update($request->all());
        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return back()->with('success', $resource->getModelName().' updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $isRemove = false;
        if(strrpos($id, 'remove')) {
            $id = str_replace('-remove', '', $id);
            $isRemove = true;
        }

        $resource = $this->model->findOrFail($id);

        $response = $this->detach($isRemove, $resource);

        if(request()->is('api/*')){
            return response()->json(['message' => $response == 1 ? 'success' : $response]);
        }
        return $response;
    }

    protected function detach($isRemove, $resource)
    {
        $documents = null;
        if(!is_null($resource->morphDocuments()) && $resource->morphDocuments()->exists()) $documents = $resource->morphDocuments();

        if($isRemove){
            foreach ($resource->getChildren() as $name => $children) {
                if(is_int($name)){
                    $children['model']->delete();
                } else $children->delete();
            }
            if(!is_null($documents)) $documents->delete();
        }
        else{
            foreach ($resource->getChildren() as $name => $children) {
                if(is_int($name)){
                    if(!is_null($children['model']) && $children['model']->exists()) return response()->json([
                        'message' => $children['message'],
                        'path' => $children['path'],
                        'status' => 0
                    ]);
                } else if (!is_null($children) && $children->exists()) return $name;
            }
            if(!is_null($documents)) return 'Documents';
        }
        $resource->delete();
        return 1;
    }

    public function show($id, Request $request)
    {
        if($id == 'find') {
            if($request->has('q')) return $this->searchByName(trim($request->q));
        }
        else if(method_exists($this->model , 'getParent')){
            if($request->has('q')) return $this->searchByParentId($id, trim($request->q));
            return $this->searchByParentId($id);
        }

    }

    private function searchByName($name)
    {
        $resources = $this->model->where("name", "LIKE", $name)->get();
        return response()->json($resources);
    }

    private function searchByParentId($id, $name = null)
    {
        $method = $this->model->getParent()['method'];
        $parent = $this->model->getParent()['model']->findOrFail($id);
        if(is_null($name)) return $parent->$method()->get();
        else return $parent->$method()->select([$this->model->searchField])->where($this->model->searchField, "=", $name)->get();
    }
}
