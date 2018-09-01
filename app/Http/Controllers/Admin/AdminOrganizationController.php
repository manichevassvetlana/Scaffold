<?php

namespace App\Http\Controllers\Admin;

use App\Abilities;
use App\Http\Controllers\ResourceController;
use App\Organization;
use App\OrganizationRoleAbilities;
use App\OrganizationRoleAbility;
use App\Organizations;
use App\Role;
use App\Roles;
use App\Users;
use Illuminate\Http\Request;

class AdminOrganizationController extends ResourceController
{
    public function __construct()
    {
        $model = new Organizations();
        $role = 'admin';
        parent::__construct($model, $role);
    }

    public function store(Request $request)
    {
        if($this->model->where('domain', $request->domain)->exists()) return back()->with('error', $this->model->getModelName().' was not created. The organization with the same domain is already exists.');

        $pivots = !is_null($request['pivot-abilities']) ? json_decode($request['pivot-abilities'], true) : null;

        $resource = $this->model->create($request->except('roles', 'abilities'));

        $roles = [];
        foreach($request->roles ?? [] as $role){
            array_push($roles, ['role' => Roles::findOrFail($role), 'ability' => null]);
        }
        $abilities = [];
        foreach($request->abilities ?? [] as $ability){
            array_push($abilities, Abilities::findOrFail($ability));
        }
        $resource->update(['roles' => $roles, 'abilities' => $abilities]);

        if(request()->is('api/*')){
            return $resource->toJson();
        }

        return redirect()->route($this->model->getRouteName().'.index');
    }

    public function update(Request $request, $id)
    {
        $resource = $this->model->findOrFail($id);
        if($this->model->where('domain', $request->domain)->exists() && $request->domain != $resource->domain) return back()->with('error', $this->model->getModelName().' was not created. The organization with the same domain is already exists.');

        if($request->has('organization_role')){
            $abilities = [];
            if ($request->has('role-abilities')) {
                foreach ($request['role-abilities'] as $ability) {
                    array_push($abilities, Abilities::findOrFail($ability)->reference());
                }
            }
            $role = Roles::findOrFail($request['organization_role']);
            $key = in_references($role->reference()->name(), $resource->roles, 'role');
            if($key === false) {
                $roleAbilities = $resource->roles + ['role' => $role, 'ability' => $abilities];
                $resource->update(['roles' => $roleAbilities]);
            } else {
                $roleAbilities = $resource->roles;
                $roleAbilities[$key]['ability'] = $abilities;
                $resource->update(['roles' => $roleAbilities]);
            }
        }
        else{
            $organizationRoles = is_array($resource->roles) ? $resource->roles : [];
            $requestRoles = $request->roles ?? [];

            foreach($organizationRoles as $k => $organizationRole){
                $find = false;
                foreach($requestRoles as $j => $role){
                    if($role == $organizationRole['role']->snapshot()->id) {
                        $find = true;
                        unset($requestRoles[$j]);
                    }
                }
                if(!$find) unset($organizationRoles[$k]);
            }
            foreach($requestRoles as $role){
                array_push($organizationRoles, ['role' => Roles::findOrFail($role), 'ability' => []]);
            }

            $abilities = [];
            foreach($request->has('abilities') ? $request->abilities : [] as $ability){
                array_push($abilities, Abilities::findOrFail($ability));
            }

            $request['roles'] = empty($organizationRoles) ? null : $organizationRoles;
            $request['abilities'] = empty($abilities) ? null : $abilities;

            $resource->update($request->all());
        }

        if(request()->is('api/*')){
            return response()->json(['status' => 'success']);
        }

        return back()->with('success', $resource->getModelName().' updated successfully.');
    }

    public function roleAbility($organizationId, $roleId)
    {
        $resource = new OrganizationRoleAbilities(Organizations::findOrFail($organizationId), Roles::findOrFail($roleId));
        if(request()->is('api/*')){
            return $resource->toJson();
        }
        return view($this->role.'._resources.editResource', compact('resource'));
    }

    public function destroyRole($role, Request $request)
    {
        $user = Users::findOrFail($request->user_id);
        $roles = $user->organization['roles'];
        unset($roles[$role]);
        $user->update(['organization.roles' => $roles], false);
    }

    public function editRole($role, Request $request)
    {
        $user = Users::findOrFail($request->user_id);
        $roles = $user->organization['roles'];
        $roles[$role] = ['role' => Roles::findOrFail($request->role_id), 'start_date' => $request->start_date, 'end_date' => $request->end_date];
        $user->update(['organization.roles' => $roles], false);
    }

    public function roleValidation(Request $request)
    {
        if($request->end_date == '-') $request['end_date'] = null;
        if (is_null($request->user_id)) return response()->json(['code' => 1]);
        $user = Users::findOrFail($request->user_id);
        $role = Roles::findOrFail($request->role_id);
        if ($request->has('organization_id') && $user->organization['id'] == $request->organization_id) {
            $id = $request->has('id') ? explode("-", $request->id)[2] : null;
            $roles = $this->getUserOrganizationRoles($user, $role);
            if (!empty($roles)) {
                if (!is_null($id)) unset($roles[$id]);

                $isUnique = $this->isRoleUnique($roles, $request->start_date, $request->end_date);
                if (!$isUnique) return getOrgUserRoleValidationCode(0);

                $dateStartNewEntry = new \DateTime($request->start_date);
                is_null($request->end_date) ? $dateEndNewEntry = null : $dateEndNewEntry = new \DateTime($request->end_date);
                if (!is_null($dateEndNewEntry) && $dateStartNewEntry > $dateEndNewEntry) return getOrgUserRoleValidationCode(0);

                foreach ($roles as $role) {
                    $dateStart = new \DateTime($role['start_date']);
                    is_null($role['end_date']) || $role['end_date'] == 0 ? $dateEnd = null : $dateEnd = new \DateTime($role['end_date']);
                    if (!is_null($dateEndNewEntry)) {
                        if ($dateStartNewEntry < $dateEnd || is_null($dateEnd)) {
                            if ($dateStart == $dateStartNewEntry || $dateStartNewEntry > $dateStart) return getOrgUserRoleValidationCode(!is_null($dateEnd) ? -1 : -2, $role['role']->snapshot()->id);
                            if ($dateStart < $dateEndNewEntry) return getOrgUserRoleValidationCode(-3);
                        }
                    } else {
                        if (!is_null($dateEnd)) {
                            if (($dateStart < $dateStartNewEntry && $dateEnd > $dateStartNewEntry) || ($dateStart >= $dateStartNewEntry)) return getOrgUserRoleValidationCode(-4, $role['role']->snapshot()->id);
                        } else {
                            if ($dateStartNewEntry < $dateStart) return getOrgUserRoleValidationCode(-5, $role['role']->snapshot()->id);
                            if ($dateStartNewEntry > $dateStart) return getOrgUserRoleValidationCode(-6, $role['role']->snapshot()->id);
                        }
                    }
                }
            }
            return getOrgUserRoleValidationCode(1);
        }
        return response()->json(['status' => -1]);
    }

    private function isRoleUnique(array $roles, $startDate, $endDate)
    {
        foreach ($roles as $role)
        {
            if(new \DateTime($role['start_date']) == new \DateTime($startDate) && new \DateTime($role['end_date']) == new \DateTime($endDate)) return false;
        }
        return true;
    }

    private function getUserOrganizationRoles(Users $user, Roles $role)
    {
        $roles = $user->organization['roles'];
        if(empty($roles) || !is_array($roles[0])) return [];
        foreach ($roles as $k => $userRole)
        {
            if($userRole['role']->name() != $role->reference()->name()) unset($roles[$k]);
        }
        return $roles;
    }
}