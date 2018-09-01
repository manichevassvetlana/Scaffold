<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Plans extends DocumentSnapshot
{
    /*Table information*/

    // The attributes that are required.
    protected $fillable = [
        'name', 'type', 'user_quantity', 'renewal_frequency', 'amount', 'status'
    ];

    public $isRemovable = true;

    public $searchField = 'name';

    /*End table information*/

    /*Relations*/

    public function lookupType(){
        return $this->belongsTo(LookupValues::class, 'type');
    }

    public function lookupStatus(){
        return $this->belongsTo(LookupValues::class, 'status');
    }

    public function subscriptions(){
        return $this->hasMany(Subscriptions::class, 'plan_id');
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
        //'name', 'type', 'user_quantity', 'renewal_frequency', 'amount', 'status'
        return [
            'name' => ['name' => 'Name', 'type' => 'text'],
            'user_quantity' => ['name' => 'User Quantity', 'type' => 'number'],
            'renewal_frequency' => ['name' => 'Renewal Frequency', 'type' => 'number'],
            'amount' => ['name' => 'Amount', 'type' => 'text'],
            'type' => ['name' => 'Type', 'type' => 'select'],
            'status' => ['name' => 'Status', 'type' => 'select'],
        ];

    }

    // Get Model name
    public function getModelName()
    {
        return 'Plan';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'plans';
    }


    // Get name of the related model
    public function getRelatedName($related)
    {
        if($related === 'type') return $this->lookupType()->value;
        else if($related === 'status') return $this->lookupStatus()->value;
    }

    public function getSelect()
    {

        $select = ['types' => [], 'statuses' => []];
        $data = ['types' => LookupValues::where('type', 'PLAN_TYPE')->get(), 'statuses' => LookupValues::where('type', 'PLAN_STATUS')->get()];

        foreach ($data as $field => $model)
        {
            foreach($model as $item)
            {
                $select[$field][$item->id] = $item->value ;
            }
        }

        return [
            'type' => $select['types'],
            'status' => $select['statuses']
        ];
    }

    // Get related models before delete the model
    public function getChildren()
    {
        $children = [
            'Subscription' => $this->subscriptions(),
        ];
        return $children;
    }

    /*End model's methods*/
}
