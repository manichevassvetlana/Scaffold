<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ResourceController;
use App\OrganizationRole;
use App\OrganizationUser;
use App\OrganizationUserRole;
use App\User;
use Illuminate\Http\Request;

class AdminOrganizationUsersController extends ResourceController
{
    public function __construct()
    {
        $model = new OrganizationUser();
        $role = 'admin';
        parent::__construct($model, $role);
    }

    public function store(Request $request)
    {
        $resource = $this->model->updateOrCreate(['user_id' => $request->user_id],
            ['type' => $request->type,
             'status' => $request->status,
             'organization_id' => $request->organization_id,
             'start_date' => $request->start_date,
             'end_date' => $request->end_date
            ]);

        if (!is_null($request['pivot-input'])) {
            $pivots = json_decode($request['pivot-input'], true);

            foreach ($pivots as $pivot) {
                $orgRoleId = OrganizationRole::where('organization_id', $resource->organization_id)->where('role_id', $pivot['role_id'])->first()->id;

                $orgUsrRole = OrganizationUserRole::create([
                    'organization_user_id' => $resource->id,
                    'organization_role_id' => $orgRoleId,
                    'start_date' => $pivot['start_date'],
                    'end_date' => $pivot['end_date'] == '' || $pivot['end_date'] == '-' ? null : $pivot['end_date']
                ]);

            }
        }

        if (request()->is('api/*')) {
            return $resource->toJson();
        }

        return redirect()->route($this->model->getRouteName() . '.index');
    }

    public function update(Request $request, $id)
    {

        $resource = $this->model->findOrFail($id);

        if ($resource->organization_id != $request->organization_id) $resource->organizationRoles()->detach();


        $resource->update($request->all());

        if (!is_null($request['pivot-input'])) {
        $pivots = json_decode($request['pivot-input'], true);
        foreach ($pivots as $pivot) {
            $orgRoleId = OrganizationRole::where('organization_id', $resource->organization_id)->where('role_id', $pivot['role_id'])->first()->id;
            OrganizationUserRole::create([
                'organization_user_id' => $resource->id,
                'organization_role_id' => $orgRoleId,
                'start_date' => $pivot['start_date'],
                'end_date' => $pivot['end_date'] == '' || $pivot['end_date'] == '-' ? null : $pivot['end_date']
            ]);

        }}

        if (request()->is('api/*')) {
            return $resource->toJson();
        }

        return back()->with('success', $resource->getModelName() . ' updated successfully.');
    }

    public function show($id, Request $request)
    {
        try {
            if (strrpos($id, 'roles') !== false) {
                $data = explode("&", $id);
                $organizationUserId = $data[1];
                return OrganizationUserRole::where('organization_user_id', $organizationUserId)->get();
            }
        } catch (\Exception $e) {
            return $e;
        }

    }

    public function destroyRole(OrganizationUserRole $role)
    {
        $role->delete();
    }

    public function editRole(OrganizationUserRole $role, Request $request)
    {
        $orgRole = OrganizationRole::where('organization_id', $request->organization_id)->where('role_id', $request->role_id)->first();
        if ($orgRole) {
            $request['organization_role_id'] = $orgRole->id;
            $role->update($request->all());
        }
    }

    public function roleValidation(Request $request)
    {
        if($request->end_date == '-') $request['end_date'] = null;
        if (is_null($request->user_id)) return response()->json(['code' => 1]);
        $orgRole = OrganizationRole::where('organization_id', $request->organization_id)->where('role_id', $request->role_id)->first();
        $orgUser = OrganizationUser::where('organization_id', $request->organization_id)->where('user_id', $request->user_id)->first();
        if ($orgRole && $orgUser) {
            $id = $request->has('id') ? $request->id : null;
            $roles = OrganizationUserRole::where('organization_user_id', $orgUser->id)->where('organization_role_id', $orgRole->id);
            if ($roles->exists()) {

                if (!is_null($id)) {
                    $currentRole = $roles->findOrFail(str_replace('old-record-', '', $id))->get();
                    unset($currentRole);
                    //$roles = $roles->get()->keyBy(str_replace('old-record-', '', $id));
                } else $roles = $roles->get();
                $isUnique = !$roles->where('start_date', $request->start_date)->where('end_date', $request->end_date)->first();
                if (!$isUnique) return getOrgUserRoleValidationCode(0);
                $dateStartNewEntry = new \DateTime($request->start_date);
                is_null($request->end_date) ? $dateEndNewEntry = null : $dateEndNewEntry = new \DateTime($request->end_date);
                if (!is_null($dateEndNewEntry) && $dateStartNewEntry > $dateEndNewEntry) return getOrgUserRoleValidationCode(0);

                foreach ($roles as $role) {
                    $dateStart = new \DateTime($role->start_date);
                    is_null($role->end_date) ? $dateEnd = null : $dateEnd = new \DateTime($role->end_date);
                    if (!is_null($dateEndNewEntry)) {
                        if ($dateStartNewEntry < $dateEnd || is_null($dateEnd)) {
                            if ($dateStart == $dateStartNewEntry || $dateStartNewEntry > $dateStart) return getOrgUserRoleValidationCode(!is_null($dateEnd) ? -1 : -2, $role->id);
                            if ($dateStart < $dateEndNewEntry) return getOrgUserRoleValidationCode(-3);
                        }
                    } else {
                        if (!is_null($dateEnd)) {
                            if (($dateStart < $dateStartNewEntry && $dateEnd > $dateStartNewEntry) || ($dateStart >= $dateStartNewEntry)) return getOrgUserRoleValidationCode(-4, $role->id);
                        } else {
                            if ($dateStartNewEntry < $dateStart) return getOrgUserRoleValidationCode(-5, $role->id);
                            if ($dateStartNewEntry > $dateStart) return getOrgUserRoleValidationCode(-6, $role->id);
                        }
                    }
                }
            }
            return getOrgUserRoleValidationCode(1);
        }
        return response()->json(['status' => -1]);
    }

    public function checkUser($id)
    {
        return AdminOrganizationController::where('user_id', $id)->exists();
    }

}