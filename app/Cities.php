<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Cities extends DocumentSnapshot
{
    /*Table information*/

    // The attributes that are mass assignable.
    protected $fillable = [
        'name', 'state_id', 'country_id', 'active',
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
        return $this->hasMany(PostalCodes::class, 'city_id');
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
            'country_id' => ['name' => 'Country', 'type' => 'select'],
            'state_id' => ['name' => 'State', 'type' => 'select'],
            'active' => ['name' => 'Active', 'type' => 'checkbox'],
        ];

    }

    // Get Model name
    public function getModelName()
    {
        return 'City';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'cities';
    }

    public function getParent()
    {
        return [
            'model' => new States(),
            'method' => 'cities'
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
        if($related === 'country_id') return $this->country()->name;
        else if($related === 'state_id') return $this->state()->name;
    }

    /*End model's methods*/
}
