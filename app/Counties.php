<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Counties extends DocumentSnapshot
{
    /*Table information*/

    // The attributes that are mass assignable.
    protected $fillable = [
        'name', 'incits', 'state_id', 'country_id', 'active'
    ];

    public $isRemovable = true;

    public $searchField = 'name';

    /*End table information*/

    /*Relations*/

    public function state(){
        return $this->belongsTo(States::class, 'state_id');
    }

    public function country(){
        return $this->belongsTo(Countries::class, 'country_id');
    }

    public function postalCodes(){
        return $this->hasMany(PostalCodes::class, 'county_id');
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
            'name' => ['name' => 'Name', 'type' => 'text'],
            'incits' => ['name' => 'Incits', 'type' => 'text'],
            'active' => ['name' => 'Active', 'type' => 'checkbox'],
            'country_id' => ['name' => 'Country', 'type' => 'select'],
            'state_id' => ['name' => 'State', 'type' => 'select']
        ];

    }

    // Get Model name
    public function getModelName()
    {
        return 'County';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'counties';
    }

    public function getParent()
    {
        return [
            'model' => new States(),
            'method' => 'counties',
            'key' => 'state_id'
        ];
    }

    // Get related models before delete the model
    public function getChildren()
    {
        $children = [
            'Postal Codes' => $this->postalCodes(),
        ];
        return $children;
    }


    // Get name of the related model
    public function getRelatedName($related)
    {
        if($related === 'state_id') return $this->state()->name;
        else if($related === 'country_id') return $this->country()->name;
    }

    /*End model's methods*/
}
