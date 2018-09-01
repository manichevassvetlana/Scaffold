<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class PostalCodes extends DocumentSnapshot
{
    /*Table information*/

    // The attributes that are mass assignable.
    protected $fillable = [
        'postal_code', 'city_id', 'county_id', 'state_id', 'country_id', 'active',
    ];

    public $isRemovable = true;

    public $searchField = 'postal_code';

    public function getParent()
    {
        return [
            'model' => new Cities(),
            'method' => 'postalCodes'
        ];
    }

    /*End table information*/

    /*Relations*/

    public function country(){
        return $this->belongsTo(Countries::class, 'country_id');
    }

    public function state(){
        return $this->belongsTo(States::class, 'state_id');
    }

    public function city(){
        return $this->belongsTo(Cities::class, 'city_id');
    }

    public function county(){
        return $this->belongsTo(Counties::class, 'county_id');
    }

    public function addresses(){
        return $this->hasMany(Addresses::class, 'postal_code_id');
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
            'postal_code' => ['name' => 'Postal Code', 'type' => 'text'],
            'country_id' => ['name' => 'Country', 'type' => 'select'],
            'state_id' => ['name' => 'State', 'type' => 'select'],
            'city_id' => ['name' => 'City', 'type' => 'select'],
            'active' => ['name' => 'Active', 'type' => 'checkbox'],
        ];

    }

    // Get Model name
    public function getModelName()
    {
        return 'Postal Code';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'postal-codes';
    }

    // Get name of the related model
    public function getRelatedName($related)
    {
        if($related === 'country_id') return $this->country()->name;
        else if($related === 'state_id') return $this->state()->name;
        else if($related === 'city_id') return $this->city()->name;
    }

    // Get related models before delete the model
    public function getChildren()
    {
        $children = [
            'Addresses' => $this->addresses(),
        ];
        return $children;
    }

    /*End model's methods*/
}
