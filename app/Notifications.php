<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Notifications extends DocumentSnapshot
{
    /*Table information*/

    // The table associated with the model.
    protected $table = 'notifications';

    // The attributes that are mass assignable.
    protected $fillable = [
        'user_id', 'icon', 'body', 'action_text', 'action_url', 'created_by', 'read'
    ];

    public $isRemovable = true;

    public $searchField = 'action_text';

    /*End table information*/

    /*Relations*/

    public function user()
    {
        return $this->belongsTo('App\Users', 'user_id');
    }

    public function owner()
    {
        return $this->belongsTo('App\Users', 'created_by');
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
            'user_id' => ['name' => 'User Name', 'type' => 'select'],
            'icon' => ['name' => 'Icon', 'type' => 'text'],
            'body' => ['name' => 'Body', 'type' => 'text'],
            'action_text' => ['name' => 'Action Text', 'type' => 'text'],
            'action_url' => ['name' => 'Action URL', 'type' => 'text'],
            'created_by' => ['name' => 'Created by', 'type' => 'select', 'edited' => 0],
        ];

    }

    // Get Model name
    public function getModelName()
    {
        return 'Notification';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'notifications';
    }

    // Get related models before delete the model
    public function getChildren()
    {
        return [];
    }


    // Get name of the related model
    public function getRelatedName($related)
    {
        if ($related === 'user_id') return $this->user()->name;
        if ($related === 'created_by') return $this->owner()->name;
    }

    /*End model's methods*/
}
