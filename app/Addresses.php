<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Addresses extends DocumentSnapshot
{
    /*Table information*/

    // The attributes that are mass assignable.
    protected $fillable = [
        'line_1', 'line_2', 'line_3', 'postal_code_id', 'city_id', 'state_id', 'country_id', 'active'
    ];

    public $isRemovable = true;

    public $searchField = 'line_1';

    /*Relations*/

    public function postalCode()
    {
        return $this->belongsTo(PostalCodes::class, 'postal_code_id');
    }

    public function city(){
        return $this->belongsTo(Cities::class, 'city_id');
    }

    public function state(){
        return $this->belongsTo(States::class, 'state_id');
    }

    public function country(){
        return $this->belongsTo(Countries::class, 'country_id');
    }

    public function locations()
    {
        return $this->hasMany(Locations::class, 'address_id');
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
            'line_1' => ['name' => 'Line 1', 'type' => 'text'],
            'line_2' => ['name' => 'Line 2', 'type' => 'text'],
            'line_3' => ['name' => 'Line 3', 'type' => 'text'],
            'country_id' => ['name' => 'Country', 'type' => 'select'],
            'state_id' => ['name' => 'State', 'type' => 'select'],
            'city_id' => ['name' => 'City', 'type' => 'select'],
            'postal_code_id' => ['name' => 'Postal Code', 'type' => 'select'],
            'active' => ['name' => 'Active', 'type' => 'checkbox'],
        ];

    }

    // Get Model name
    public function getModelName()
    {
        return 'Address';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'addresses';
    }

    public function getParent()
    {
        return [
            'model' => new PostalCodes(),
            'method' => 'addresses'
        ];
    }

    // Get name of the related model
    public function getRelatedName($related)
    {
        if ($related === 'country_id') return $this->country()->name;
        else if ($related === 'state_id') return $this->state()->name;
        else if ($related === 'city_id') return $this->city()->name;
        else if ($related === 'postal_code_id') return $this->postalCode()->postal_code;
    }

    // Get related models before delete the model
    public function getChildren()
    {
        $children = [
            'Locations' => $this->locations(),
        ];
        return $children;
    }

    /*End model's methods*/
}