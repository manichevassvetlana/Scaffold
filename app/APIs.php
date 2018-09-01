<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Apis extends DocumentSnapshot
{
    /*Table information*/

    protected $fillable = [
        'type', 'name', 'version', 'deprecated', 'deprecated_at',
    ];

    protected $appends = [
        'type_api'
    ];


    public function getTypeAPIAttribute()
    {
        return $this->type;
    }

    public $isRemovable = true;

    public $searchField = 'name';

    /*End table information*/

    /*Relations*/

    public function morphDocuments()
    {
        return $this->morphMany(Documents::class, 'reference');
    }
    public function lookupType()
    {
        return $this->belongsTo(LookupValues::class, 'type');
    }

    /*End relations*/

    /*Model's methods*/

    public function reference_type()
    {
        $reference_type = LookupValues::where("type", "=", "REFERENCE_TYPE")->where("value", "=", "App\API");
        return $reference_type;
    }

    // Get Model fields for CRUD operations in view
    public function getFields()
    {
        return [
            'type_api' => ['name' => 'Type', 'type' => 'select'],
            'name' => ['name' => 'Name', 'type' => 'text'],
            'version' => ['name' => 'Version', 'type' => 'text'],
            'deprecated' => ['name' => 'Deprecated', 'type' => 'checkbox'],
            'deprecated_at' => ['name' => 'Deprecated Date', 'type' => 'datetime'],
        ];

    }

    // Get Model name
    public function getModelName()
    {
        return 'API';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'apis';
    }

    // Get related models before delete the model
    public function getChildren()
    {
        return [];
    }


    // Get name of the related model
    public function getRelatedName($related)
    {
        if($related === 'type_api') return $this->lookupType()->value;
    }

    /*End model's methods*/
}
