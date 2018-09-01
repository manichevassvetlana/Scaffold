<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Roles extends DocumentSnapshot
{
    /*Table information*/

    // The table associated with the model.
    protected $table = 'roles';

    // The attributes that are mass assignable.
    protected $fillable = [
        'name', 'type'
    ];

    // Can the resource be deleted
    public $isRemovable = true;

    // The field to be searched for
    public $searchField = 'name';

    /*End table information*/

    public function lookupType()
    {
        return $this->belongsTo(LookupValues::class, 'type');
    }

    public function morphDocuments()
    {
        return $this->morphMany(Documents::class, 'reference');
    }

    /*Model's methods*/

    // Get Model fields for CRUD operations
    public function getFields()
    {
        $fields = [
            'name' => ['name' => 'Name', 'type' => 'text'],
            'type' => ['name' => 'Type', 'type' => 'select']
        ];

        return $fields;
    }

    // Get Model name
    public function getModelName()
    {
        return 'Role';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'roles';
    }

    // Get name of the related model
    public function getRelatedName($related)
    {
        if($related === 'type') return $this->lookupType()->value;
    }

    // Get select options
    public function getSelect()
    {
        $select = ['type' => []];
        $data = ['type' => LookupValues::where('type', 'ROLE_TYPE')];

        foreach ($data as $field => $model) {
            foreach ($model->get() as $item) {
                $select[$field][$item->id] = $item->value;
            }
        }
        return $select;
    }

    // Get related models before delete the model
    public function getChildren()
    {
        $children = [];
        return $children;
    }

    /*End model's methods*/
}
