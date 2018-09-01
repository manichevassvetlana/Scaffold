<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Organizations extends DocumentSnapshot
{
    /*Table information*/

    // The attributes that are mass assignable.
    protected $fillable = [
        'name', 'domain', 'type', 'status', 'roles', 'abilities'
    ];

    public $isRemovable = true;

    public $searchField = 'name';

    /*End table information*/

    /*Relations*/

    public function lookupType(){
        return $this->belongsTo(LookupValues::class, 'type');
    }

    public function lookupStatus(){
        return $this->belongsTo(LookupValues::class, 'status');
    }

    public function users()
    {
        return Users::where('organization.id', $this->id);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscriptions::class, 'organization_id');
    }

    public function morphDocuments()
    {
        return $this->morphMany(Documents::class, 'reference');
    }

    /*End relations*/

    /*Model's methods*/

    // Get Model fields for CRUD operations in view
    public function getFields()
    {
        $fields = [
            'name' => ['name' => 'Name', 'type' => 'text'],
            'domain' => ['name' => 'Domain', 'type' => 'text'],
            'type' => ['name' => 'Type', 'type' => 'select'],
            'status' => ['name' => 'Status', 'type' => 'select'],
            'abilities' => ['name' => 'Abilities', 'type' => 'new-pivot', 'elements' => Abilities::all(), 'hidden' => 1],
            'roles' => ['name' => 'Roles', 'type' => 'new-pivot', 'elements' => Roles::where('type', getLookupValue('ROLE_TYPE', 'Organization')->id)->get(), 'hidden' => 1, 'manageble' => 1, 'manage_text' => 'Manage Abilities'],

        ];

        return $fields;
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

    // Get name of the related model
    public function getRelatedName($related)
    {
        if($related === 'type') return $this->lookupType()->value;
        else if($related === 'status') return $this->lookupStatus()->value;
    }

    // Get select options
    public function getSelect()
    {

        $select = ['types' => [], 'statuses' => []];
        $data = ['types' => LookupValues::where('type', 'ORG_TYPE'), 'statuses' => LookupValues::where('type', 'ORG_STATUS')];

        foreach ($data as $field => $model)
        {
            foreach($model->get() as $item)
            {
                $select[$field][$item->id] = $item->value ;
            }
        }

        return [
            'type' => $select['types'],
            'status' => $select['statuses']
        ];
    }

    public function getPivot($pivot, $element)
    {
        return in_references($element->reference()->name(), $this->$pivot, $pivot == 'roles' ? 'role' : false);
    }

    // Get the owner of the organization
    public function getOwner()
    {
        $owner = $this->users()->where('organization.type', getLookupValue('ORG_USER_TYPE', 'Owner')->id)->first();
        return $owner ?? false;
    }

    // Get related models before delete the model
    public function getChildren()
    {
        $children = [
            'Users' => $this->users(),
            'Subscriptions' => $this->subscriptions(),
        ];
        return $children;
    }

    /*End model's methods*/
}
