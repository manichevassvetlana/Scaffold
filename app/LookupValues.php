<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class LookupValues extends DocumentSnapshot
{
    protected $fillable = ['type', 'value', 'description','starts_at', 'ends_at'];

    // Get Model name
    public function getModelName()
    {
        return 'Lookup Value';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'lookup-values';
    }

    public $isRemovable = true;

    public $searchField = 'value';

    // Get Model fields for CRUD operations in view
    public function getFields()
    {
        return [
            'type' => ['name' => 'Type', 'type' => 'text'],
            'value' => ['name' => 'Value', 'type' => 'text'],
            'description' => ['name' => 'Description', 'type' => 'textarea'],
            'starts_at' => ['name' => 'Starts at', 'type' => 'datetime'],
            'ends_at' => ['name' => 'Ends at', 'type' => 'datetime', 'optional' => 1]
        ];

    }

    // Get related models before delete the model
    public function getChildren()
    {
        $children = [
            'Organizations Statuses' => $this->organizationStatuses(),
            'Organizations Types' => $this->organizationTypes(),

            'Page Statuses' => $this->pageStatuses(),

            'Plan Statuses' => $this->planStatuses(),
            'Plan Types' => $this->planTypes(),

            'Role Types' => $this->roleTypes(),

            'Subscription Statuses' => $this->subscriptionStatuses(),

            'Categories' => $this->categoriesTypes(),
        ];
        return $children;
    }

    public function organizationStatuses(){
        return $this->hasMany(Organizations::class, 'status');
    }
    public function organizationTypes(){
        return $this->hasMany(Organizations::class, 'type');
    }

    public function pageStatuses(){
        return $this->hasMany(Pages::class, 'status');
    }

    public function planStatuses(){
        return $this->hasMany(Plans::class, 'status');
    }
    public function planTypes(){
        return $this->hasMany(Plans::class, 'type');
    }

    public function roleTypes(){
        return $this->hasMany(Roles::class, 'type');
    }

    public function subscriptionStatuses(){
        return $this->hasMany(Subscriptions::class, 'status');
    }

    public function categoriesTypes(){
        return $this->hasMany(Categories::class, 'type');
    }

    public function morphDocuments()
    {
        return $this->morphMany(Documents::class, 'reference');
    }

}
