<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Developers extends DocumentSnapshot
{
    /*Table information*/

    // The attributes that are mass assignable.
    protected $fillable = [
        'user_id', 'use_description', 'preferred_languages', 'personal_use', 'business_use',
    ];

    public $isRemovable = true;

    public $searchField = 'use_description';

    /*End table information*/

    /*Relations*/

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
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
            'user_id' => ['name' => 'User', 'type' => 'select'],
            'use_description' => ['name' => 'Use Description', 'type' => 'textarea'],
            'preferred_languages' => ['name' => 'Preferred languages', 'type' => 'text'],
            'personal_use' => ['name' => 'Personal Use', 'type' => 'checkbox'],
            'business_use' => ['name' => 'Business Use', 'type' => 'checkbox'],
        ];

    }

    // Get Model name
    public function getModelName()
    {
        return 'Developer';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'developers';
    }

    // Get related models before delete the model
    public function getChildren()
    {
        return [];
    }


    // Get name of the related model
    public function getRelatedName($related)
    {
        if($related === 'user_id') return $this->user()->name;
    }

    /*End model's methods*/
}
