<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirestoreController extends Controller
{
    public $model;

    public function __construct($model) {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = new $this->model;
        $count = request('count') ?? 10;
        $page = request('start_at') ?? false;
        $search = request('search') ?? false;
        $resources = $res;

        if($search) $resources = $res->where($this->model->searchField, 'like', $search);
        else !$page ? $resources = $resources->paginate($count) : $resources = $resources->paginate($count, $page);
        $length = count($resources);
        $page = $resources[$length - 1][$this->model->searchField];

        $length < $count ? $length = false : $length = true;

        if(request()->is('api/*')){
            return $resources->toJson();
        }

        $countArray = [10, 25, 50, 100];
        return view('admin._resources.resources', compact('res', 'resources', 'count', 'page', 'countArray', 'search', 'length'));
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
        return view('admin._resources.createResource', compact('resource'));
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
        return view('admin._resources.editResource', compact('resource'));
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
        // TODO: add check for documents (check if reference type for model exists + model's id in documents table)
        $documents = null;
        if($resource->morphDocuments()->exists()) $documents = $resource->morphDocuments();

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
                    if($children['model']->exists()) return response()->json([
                        'message' => $children['message'],
                        'path' => $children['path'],
                        'status' => 0
                    ]);
                } else if ($children->exists()) return $name;
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
        $resources = $this->model->where("name", "like", $name);
        return response()->json($resources);
    }

    private function searchByParentId($id, $name = null)
    {
        $method = $this->model->getParent()['method'];
        $parent = $this->model->getParent()['model']->findOrFail($id);
        if(is_null($name)) return $parent->$method();
        else return collect($parent->$method()->where($this->model->searchField, "=", $name)->documents());
    }
}
