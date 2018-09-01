<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Documents extends DocumentSnapshot
{
    /*Table information*/

    // The attributes that are mass assignable.
    protected $fillable = [
        'category_id', 'reference_type', 'reference_id', 'title', 'author_id', 'body', 'version',
    ];

    protected $appends = [
        'entityRelationship', 'user_id'
    ];

    public function getEntityRelationshipAttribute()
    {
        return EntityRelationships::where('path', $this->reference_type)->first();
    }

    public $isRemovable = true;

    public $searchField = 'title';

    /*End table information*/

    /*Relations*/

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(Users::class, 'author_id');
    }

    public function entityRelationship()
    {
        return $this->belongsTo(EntityRelationships::class, 'reference_type', 'path');
    }

    /*End relations*/

    /*Model's methods*/

    // Get Model fields for CRUD operations in view
    public function getFields()
    {
        return [
            'author_id' => ['name' => 'Author', 'type' => 'select', 'as' => 'user_id'],
            'category_id' => ['name' => 'Category', 'type' => 'select'],
            'reference_type' => ['name' => 'Reference type', 'type' => 'select'],
            'reference_id' => ['name' => 'Reference', 'type' => 'select'],
            'version' => ['name' => 'Version', 'type' => 'text'],
            'title' => ['name' => 'Title', 'type' => 'text'],
            'body' => ['name' => 'Body', 'type' => 'textarea'],
        ];

    }

    public function getSelect()
    {
        $referenceTypes = [0 => '-- Reference Type --'];
        foreach(EntityRelationships::all() as $referenceType){
            $referenceTypes[$referenceType->id] = $referenceType->name;
        }
        $categories = [];
        foreach(Categories::where('type', getLookupValue('CATEGORY_TYPE', 'Document')->id)->get() as $category){
            $categories[$category->id] = $category->name;
        }
        return [
            'reference_type' => $referenceTypes,
            'category_id' => $categories,
        ];
        //return [];
    }

    // Get Model name
    public function getModelName()
    {
        return 'Document';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'documents';
    }

    // Get related models before delete the model
    public function getChildren()
    {
        return [];
    }


    // Get name of the related model
    public function getRelatedName($related)
    {
        if ($related === 'author_id') return $this->author()->name;
        else if ($related === 'category_id') return $this->category()->name;
        else if ($related === 'reference_type') return $this->reference_type;
        else if ($related === 'reference_id') {
            $reference = $this->getReferenceClass();
            $field = $reference->searchField;
            return $reference->findOrFail($this->reference_id)->$field;
        }
    }

    public function getReferenceClass()
    {
        $class = $this->reference_type;
        $reference = new $class();
        return $reference;
    }

    /*End model's methods*/
}
