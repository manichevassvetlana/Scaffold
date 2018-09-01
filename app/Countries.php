<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Countries extends DocumentSnapshot
{
    /*Table information*/

    // The table associated with the model.
    protected $table = 'countries';

    // The attributes that are mass assignable.
    protected $fillable = [
        'name', 'alpha_2_code', 'alpha_3_code', 'numeric_code', 'active',
    ];

    public $isRemovable = true;

    public $searchField = 'name';

    /*End table information*/

    /*Relations*/

    public function states(){
        return $this->hasMany(States::class, 'country_id');
    }

    public function addresses(){
        return $this->hasMany(Addresses::class, 'country_id');
    }

    public function locations(){
        return $this->hasMany(Locations::class, 'country_id');
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
            'alpha_2_code' => ['name' => 'Alpha 2 Code', 'type' => 'text'],
            'alpha_3_code' => ['name' => 'Alpha 3 Code', 'type' => 'text'],
            'numeric_code' => ['name' => 'Numeric Code', 'type' => 'text'],
            'active' => ['name' => 'Active', 'type' => 'checkbox'],
        ];

    }

    // Get Model name
    public function getModelName()
    {
        return 'Country';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'countries';
    }


    public function getChildren()
    {
        $children = [
            'States' => $this->states(),
            'Addresses' => $this->addresses(),
            'Locations' => $this->locations(),
        ];
        return $children;
    }

    /*End model's methods*/
}
