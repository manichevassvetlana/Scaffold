<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\Organization;
use App\OrganizationRole;
use App\OrganizationRoleAbility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminOrganizationRoleAbility extends ResourceController
{
    public function __construct()
    {
        $model = new OrganizationRoleAbility();
        $role = 'admin';
        parent::__construct($model, $role);
    }


    public function show($id, Request $request)
    {
        $organization = Organization::findOrFail($id);

        if(request()->is('api/*')){
            return $organization->roles->toJson();
        }

        return $organization->roles;
    }

    public function store(Request $request)
    {
        $orgRole = OrganizationRole::where('organization_id', $request->organization_id)->where('role_id', $request->role_id)->first();
        if($orgRole)
        {
            $request['organization_role_id'] = $orgRole->id;
            $resource = $this->model->create($request->all());

            if(request()->is('api/*')){
                return $resource->toJson();
            }
        }
        return redirect()->route($this->model->getRouteName().'.index');
    }

    public function update(Request $request, $id)
    {
        $resource = $this->model->findOrFail($id);
        $orgRole = OrganizationRole::where('organization_id', $request->organization_id)->where('role_id', $request->organization_id)->first();
        if($orgRole)
        {
            $request['organization_role_id'] = $orgRole->id;
            $resource->update($request->all());

            if(request()->is('api/*')){
                return $resource->toJson();
            }

            return back()->with('success', $resource->getModelName().' updated successfully.');
        }
        else return back()->with('error', $resource->getModelName().' was not updated.');
    }
}
