<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Categories extends DocumentSnapshot
{
    /*Table information*/

    // The attributes that are mass assignable.
    protected $fillable = [
        'type', 'parent_id', 'order', 'name'
    ];

    protected $appends = [
        'type_category'
    ];

    public function getTypeCategoryAttribute()
    {
        return $this->type;
    }

    public $isRemovable = true;

    public $searchField = 'name';

    /*End table information*/

    /*Relations*/

    public function children()
    {
        return $this->hasMany(Categories::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Categories::class, 'parent_id');
    }

    public function documents()
    {
        return $this->hasMany(Documents::class, 'reference');
    }

    public function lookupType()
    {
        return $this->belongsTo(LookupValues::class, 'type');
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
        return [
            'type_category' => ['name' => 'Type', 'type' => 'select'],
            'name' => ['name' => 'Name', 'type' => 'text'],
            'parent_id' => ['name' => 'Parent', 'type' => 'select'],
            'order' => ['name' => 'Order', 'type' => 'text'],
        ];

    }

    // Get Model name
    public function getModelName()
    {
        return 'Category';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'categories';
    }

    // Get related models before delete the model
    public function getChildren()
    {
        $children = [
            'Documents' => $this->documents(),
            'Categories' => $this->children(),
        ];
        return $children;
    }


    // Get name of the related model
    public function getRelatedName($related)
    {
        if($related === 'parent_id') return $this->parent()->name;
        else if($related === 'type_category') return $this->lookupType()->value;
    }

    /*End model's methods*/
}
