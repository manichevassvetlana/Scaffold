<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\FileController;
use App\Http\Controllers\ResourceController;
use App\Roles;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends ResourceController
{
    public function __construct()
    {
        $model = new Users();
        parent::__construct($model);
    }

    public function store(Request $request)
    {
        return redirect('/admin/users');
    }

    public function create()
    {
        return redirect('/admin/users');
    }

    public function update(Request $request, $id)
    {
        ($request->has('active') && $request->active == 'on') ? $request['active'] = 1 : $request['active'] = 0;

        $resource = $this->model->findOrFail($id);

        if (!is_null($request['pivot-input'])) {
            $pivots = json_decode($request['pivot-input'], true);
            $requestRoles = [];
            foreach ($pivots as $pivot) {
                array_push($requestRoles, ['role' => Roles::findOrFail($pivot['role_id']), 'start_date' => $pivot['start_date'], 'end_date' => $pivot['end_date']]);
            }
            $requestOrganization = $request['organization'];
            $requestOrganization['roles'] = $requestRoles;
            $request['organization'] = $requestOrganization;
        }

        $roles = [];
        foreach($request->has('roles') ? $request->roles : [] as $role){
            array_push($roles, Roles::findOrFail($role));
        }
        $request['roles'] = $roles;

        $resource->update($request->except('pivot_input'));

        if(request()->is('api/*')){
            return response()->json(['status' => 'Resource was updated successfully']);
        }

        return back()->with('success', $resource->getModelName().' updated successfully.');
    }

    public function show($id, Request $request) {

        $users = [];

        if($request->has('q')) {
            $search = trim($request->q);
            $users = new Users();
            $users = $users
                ->select(["id","name","email"])
                ->where($users->searchField, "=", $search)
                ->get();
        }
        return $users;

    }

    public function profile()
    {
        return view('user.profile.view');
    }

    public function editProfile()
    {
        return view('user.profile.edit');
    }

    public function notifications()
    {
        return fire_auth()->user()->getUnreadNotifications();
    }

    public function announcements()
    {
        return fire_auth()->user()->getUnreadAnnouncements();
    }

    public function updateProfile(Request $request)
    {
        if($request->hasFile('image') && $request->file('image')){
            $image = $request['profile-image'];
            if(fire_auth()->user()->image !== 0) FileController::remove(fire_auth()->user()->image);
            fire_auth()->user()->update(['image' => $image, 'name' => $request->name]);
        }
        return $this->profile();
    }

    public function impersonate(Users $user)
    {
        Auth::user()->impersonate($user);
        return redirect('/dashboard');
    }

    public function impersonateLeave()
    {
        Auth::user()->leaveImpersonation();
        return redirect('/dashboard');
    }

}
