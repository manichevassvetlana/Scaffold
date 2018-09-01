<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Announcements extends DocumentSnapshot
{
    /*Table information*/

    // The attributes that are mass assignable.
    protected $fillable = [
        'user_id', 'body', 'action_text', 'action_url', 'read'
    ];

    public $isRemovable = true;

    public $searchField = 'action_text';

    /*End table information*/

    /*Relations*/

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id');
    }

    public function morphDocuments()
    {
        return $this->morphMany(Document::class, 'reference');
    }

    /*End relations*/

    /*Model's methods*/

    // Get Model fields for CRUD operations in view
    public function getFields()
    {
        return [
            'user_id' => ['name' => 'User Name', 'type' => 'select'],
            'action_text' => ['name' => 'Action Text', 'type' => 'text'],
            'action_url' => ['name' => 'Action URL', 'type' => 'text'],
            'body' => ['name' => 'Body', 'type' => 'editor'],
        ];

    }

    // Get Model name
    public function getModelName()
    {
        return 'Announcement';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'announcements';
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
