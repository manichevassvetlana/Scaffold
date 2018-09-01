<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Subscriptions extends DocumentSnapshot
{
    /*Table information*/

    // The attributes that are mass assignable.
    protected $fillable = [
        'organization_id', 'plan_id', 'status', 'start_date', 'end_date', 'renewal_date', 'cancelled_date'
    ];

    public $isRemovable = true;

    public $searchField = 'start_date';

    /*End table information*/

    public function organization()
    {
        return $this->belongsTo(Organizations::class, 'organization_id');
    }

    public function plan()
    {
        return $this->belongsTo(Plans::class, 'plan_id');
    }

    public function lookupStatus()
    {
        return $this->belongsTo(LookupValues::class, 'status');
    }

    public function morphDocuments()
    {
        return $this->morphMany(Documents::class, 'reference');
    }

    /*Model's methods*/

    // Get Model fields for CRUD operations in view
    public function getFields()
    {
        $fields = [
            'organization_id' => ['name' => 'Organization', 'type' => 'select'],
            'plan_id' => ['name' => 'Plan', 'type' => 'select'],
            'status' => ['name' => 'Status', 'type' => 'select'],
            'start_date' => ['name' => 'Start Date', 'type' => 'datetime'],
            'end_date' => ['name' => 'End Date', 'type' => 'datetime', 'optional' => 1],
            'renewal_date' => ['name' => 'Renewal Date', 'type' => 'datetime', 'optional' => 1],
            'cancelled_date' => ['name' => 'Cancelled Date', 'type' => 'datetime', 'optional' => 1],
        ];

        return $fields;
    }

    // Get Model name
    public function getModelName()
    {
        return 'Subscription';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'subscriptions';
    }

    public function getSelect()
    {
        $select['plan_id'] = [];
        foreach (Plans::all() as $plan) $select['plan_id'][$plan->id] = $plan->name;

        $select['status'] = [];
        foreach (LookupValues::where('type', 'SUBSCRIPTION_STATUS')->get() as $status) $select['status'][$status->id] = $status->value;

        return $select;
    }

    // Get name of the related model
    public function getRelatedName($related)
    {
        if($related === 'status') return $this->lookupStatus()->value;
        else if($related === 'plan_id') return $this->plan()->name;
        else if($related === 'organization_id') return $this->organization()->name;
    }

    // Get related models before delete the model
    public function getChildren()
    {
        return [];
    }


    /*End model's methods*/
}
