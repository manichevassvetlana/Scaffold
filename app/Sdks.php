<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Sdks extends DocumentSnapshot
{
    /*Table information*/

    // The attributes that are mass assignable.
    protected $fillable = [
        'type', 'name', 'version'
    ];

    protected $appends = [
        'type_sdk'
    ];

    public function getTypeSdkAttribute()
    {
        return $this->type;
    }

    public $isRemovable = true;

    public $searchField = 'name';

    /*End table information*/

    public function morphDocuments()
    {
        return $this->morphMany(Documents::class, 'reference');
    }

    public function lookupType()
    {
        return $this->belongsTo(LookupValues::class, 'type');
    }

    /*Model's methods*/

    // Get Model fields for CRUD operations in view
    public function getFields()
    {
        return [
            'type_sdk' => ['name' => 'Type', 'type' => 'select'],
            'version' => ['name' => 'Version', 'type' => 'text'],
            'name' => ['name' => 'Name', 'type' => 'text']
        ];

    }

    public function getSelect()
    {
        $referenceTypes = [];
        foreach(LookupValues::where('type', 'SDK_TYPE')->get() as $referenceType){
            $referenceTypes[$referenceType->id] = $referenceType->value;
        }
        return [
            'type_sdk' => $referenceTypes
        ];
    }

    // Get Model name
    public function getModelName()
    {
        return 'SDK';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'sdks';
    }


    // Get name of the related model
    public function getRelatedName($related)
    {
        if ($related === 'type_sdk') return $this->lookupType()->value;
    }

    // Get related models before delete the model
    public function getChildren()
    {
        return [];
    }

    /*End model's methods*/
}
