<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class States extends DocumentSnapshot
{
    /*Table information*/

    // The attributes that are mass assignable.
    protected $fillable = [
        'name', 'abbreviation', 'country_id', 'active',
    ];

    public $isRemovable = true;

    public $searchField = 'name';

    /*End table information*/

    /*Relations*/

    public function country(){
        return $this->belongsTo(Countries::class, 'country_id');
    }

    public function cities(){
        return $this->hasMany(Cities::class, 'state_id');
    }

    public function counties(){
        return $this->hasMany(Counties::class, 'state_id');
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
            'abbreviation' => ['name' => 'Abbreviation', 'type' => 'text'],
            'active' => ['name' => 'Active', 'type' => 'checkbox'],
            'country_id' => ['name' => 'Country', 'type' => 'select'],
        ];

    }

    // Get Model name
    public function getModelName()
    {
        return 'State';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'states';
    }

    public function getParent()
    {
        return [
            'model' => new Countries(),
            'method' => 'states'
        ];
    }

    // Get name of the related model
    public function getRelatedName($related)
    {
        if($related === 'country_id') return $this->country()->name;
    }

    // Get related models before delete the model
    public function getChildren()
    {
        $children = [
            'Cities' => $this->cities(),
        ];
        return $children;
    }

    /*End model's methods*/

}
