<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Repositories extends DocumentSnapshot
{
    /*Table information*/

    // The table associated with the model.
    protected $table = 'repositories';

    // The attributes that are mass assignable.
    protected $fillable = [
        'type', 'url', 'name', 'contributors',
    ];

    protected $appends = [
        'type_repository'
    ];

    public function getTypeRepositoryAttribute()
    {
        return $this->type;
    }

    public $isRemovable = true;

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

    // Get Model fields for CRUD operations in view
    public function getFields()
    {
        return [
            'type_repository' => ['name' => 'Type', 'type' => 'select'],
            'url' => ['name' => 'URL', 'type' => 'text'],
            'name' => ['name' => 'Name', 'type' => 'text'],
            'contributors' => ['name' => 'Contributors', 'type' => 'text'],
        ];

    }

    public function getSelect()
    {
        $referenceTypes = [];
        foreach(LookupValues::where('type', 'REPOSITORY_TYPE')->get() as $referenceType){
            $referenceTypes[$referenceType->id] = $referenceType->value;
        }
        return [
            'type_repository' => $referenceTypes
        ];
    }

    // Get Model name
    public function getModelName()
    {
        return 'Repository';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'repositories';
    }

    // Get name of the related model
    public function getRelatedName($related)
    {
        if ($related === 'type_repository') return $this->lookupType()->value;
    }

    // Get related models before delete the model
    public function getChildren()
    {
        return [];
    }

    /*End model's methods*/
}
