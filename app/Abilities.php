<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Abilities extends DocumentSnapshot
{
    /*Table information*/

    // The attributes that are mass assignable.
    protected $fillable = [
        'name', 'function'
    ];

    public $isRemovable = true;

    public $searchField = 'name';

    /*End table information*/

    /*Relations*/

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
            'function' => ['name' => 'Function', 'type' => 'text'],
        ];

    }

    // Get Model name
    public function getModelName()
    {
        return 'Ability';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'abilities';
    }

    // Get related models before delete the model
    public function getChildren()
    {
        $children = [];
        return $children;
    }

    /*End model's methods*/
}
