<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Locations extends DocumentSnapshot
{
    /*Table information*/

    // The attributes that are mass assignable.
    protected $fillable = [
        'position', 'address_id', 'postal_code_id', 'county_id', 'city_id', 'state_id', 'country_id', 'description', 'name'
    ];


    protected $appends = [
        'latitude', 'longitude'
    ];

    public $isRemovable = true;

    public $searchField = 'name';

    public function getLatitudeAttribute(){
        return !is_int($this->position) ? $this->position->latitude() : null;
    }

    public function getLongitudeAttribute(){
        return !is_int($this->position) ? $this->position->longitude() : null;
    }

    /*End table information*/

    /*Relations*/

    public function state(){
        return $this->belongsTo(States::class, 'state_id');
    }

    public function city(){
        return $this->belongsTo(Cities::class, 'city_id');
    }

    public function country(){
        return $this->belongsTo(Countries::class, 'country_id');
    }

    public function postalCode(){
        return $this->belongsTo(PostalCodes::class, 'postal_code_id');
    }

    public function address(){
        return $this->belongsTo(Addresses::class, 'address_id');
    }

    public function county(){
        return $this->belongsTo(Counties::class, 'county_id');
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
            'position' => ['name' => 'Position', 'type' => 'point', 'hidden' => 1],
            'name' => ['name' => 'Name', 'type' => 'text'],
            'description' => ['name' => 'Description', 'type' => 'textarea'],
            'country_id' => ['name' => 'Country', 'type' => 'select'],
            'state_id' => ['name' => 'State', 'type' => 'select', 'optional' => 1],
            'city_id' => ['name' => 'City', 'type' => 'select', 'optional' => 1],
            'postal_code_id' => ['name' => 'Postal Code', 'type' => 'select', 'optional' => 1],
            'county_id' => ['name' => 'County', 'type' => 'select', 'optional' => 1],
            'address_id' => ['name' => 'Address', 'type' => 'select', 'optional' => 1],
        ];

    }

    // Get Model name
    public function getModelName()
    {
        return 'Location';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'locations';
    }

    public function getParent()
    {
        return [
            'model' => new Address(),
            'method' => 'locations'
        ];
    }

    // Get related models before delete the model
    public function getChildren()
    {
        return [];
    }


    // Get name of the related model
    public function getRelatedName($related)
    {
        if($related === 'country_id') if($this->country()) return $this->country()->name; else return '';
        else if($related === 'state_id') if($this->state()) return $this->state()->name; else return '';
        else if($related === 'city_id') if($this->city()) return $this->city()->name; else return '';
        else if($related === 'postal_code_id') if($this->postalCode()) return $this->postalCode()->postal_code; else return '';
        else if($related === 'address_id') if($this->address()) return $this->address()->line_1.' '.$this->address()->line_2.' '.$this->address()->line_3; else return '';
        else if($related === 'county_id') if($this->county()) return $this->county()->name; else return '';
    }

    /*End model's methods*/
}
