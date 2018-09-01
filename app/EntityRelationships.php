<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class EntityRelationships extends DocumentSnapshot
{
    /*Table information*/

    // The table associated with the model.
    protected $table = 'entity_relationships';

    // The attributes that are mass assignable.
    protected $fillable = [
        'name', 'model', 'path', 'starts_at', 'ends_at'
    ];

    public $isRemovable = true;

    public $searchField = 'name';

    /*End table information*/

    public function morphDocuments()
    {
        return $this->morphMany(Documents::class, 'reference');
    }

    /*Model's methods*/

    // Get Model fields for CRUD operations in view
    public function getFields()
    {
        return [
            'name' => ['name' => 'Name', 'type' => 'text'],
            'model' => ['name' => 'Model', 'type' => 'text'],
            'path' => ['name' => 'Path', 'type' => 'text'],
            'starts_at' => ['name' => 'Starts at', 'type' => 'datetime'],
            'ends_at' => ['name' => 'Ends at', 'type' => 'datetime', 'optional' => 1]
        ];

    }

    // Get Model name
    public function getModelName()
    {
        return 'Entity Relationship';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'entity-relationships';
    }

    // Get related models before delete the model
    public function getChildren()
    {
        return [];
    }

    public function getReference()
    {
        $class = $this->path;
        $reference = new $class();
        return $reference;
    }

    /*End model's methods*/
}
