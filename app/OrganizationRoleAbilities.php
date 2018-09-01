<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizationRoleAbilities
{
    private $role;
    private $organization;
    private $key;

    public $organization_role;
    public $id;

    public function __construct(Organizations $organization, Roles $role)
    {
        $this->role = $role;
        $this->organization = $organization;

        $this->organization_role = $role->id;
        $this->id = $organization->id;

        $this->key = in_references($role->reference()->name(), $this->organization->roles, 'role');
    }

    /*Model's methods*/

    // Get Model fields for CRUD operations in view
    public function getFields()
    {
        $fields = [
            'organization_role' => ['name' => 'Role', 'type' => 'select'],
            'abilities' => ['name' => 'Role-Abilities', 'type' => 'new-pivot', 'elements' => $this->getAbilities(), 'hidden' => 1]
        ];
        return $fields;
    }

    // Get name of the related model
    public function getRelatedName($related)
    {
        if($related === 'organization_role') return $this->role->name;
    }

    public function getAbilities()
    {
        $abilities = $this->organization->abilities;
        if(empty($abilities)) return [];
        else {
            $response = [];
            foreach ($abilities as $k => $ability){
                array_push($response, $ability->snapshot());
            }
            return $response;
        }
    }

    public function getPivot($pivot, $element)
    {
        return $this->key === false ? false : in_references($element->reference()->name(), $this->organization->roles[$this->key]['ability']);
    }

    // Get Model name
    public function getModelName()
    {
        return 'Organization';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'organizations';
    }
}
