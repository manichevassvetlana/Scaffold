<?php

namespace App;

use WebsolutionsGroup\Firestore\DocumentSnapshot;

class Pages extends DocumentSnapshot
{
    /*Table information*/

    // The attributes that are mass assignable.
    protected $fillable = [
        'slug', 'created_by', 'version_id', 'status', 'versions'
    ];

    protected $appends = [
        'name', 'type', 'description', 'title', 'content', 'layout', 'author',
        'excerpt', 'meta_description', 'meta_keywords', 'image', 'updated_by', 'page_id', 'updated_at', 'user_id'
    ];

    public $isRemovable = true;
    public $searchField = 'slug';

    public function getUpdatedByAttribute()
    {
        return $this->pageVersion()['updated_by']->snapshot()->id;
    }

    public function getNameAttribute()
    {
        return $this->pageVersion()['name'];
    }

    public function getTypeAttribute()
    {
        return $this->pageVersion()['type']->snapshot()->id;
    }

    public function getDescriptionAttribute()
    {
        return $this->pageVersion()['description'];
    }

    public function getTitleAttribute()
    {
        return $this->pageVersion()['title'];
    }

    public function getContentAttribute()
    {
        return $this->pageVersion()['content'];
    }

    public function getLayoutAttribute()
    {
        return $this->pageVersion()['layout']->snapshot()->id;
    }

    public function getAuthorIdAttribute()
    {
        return $this->pageVersion()['author']->snapshot()->id;
    }

    public function getUserIdAttribute()
    {
        return $this->pageVersion()['author']->snapshot()->id;
    }

    public function getExcerptAttribute()
    {
        return $this->pageVersion()['excerpt'];
    }

    public function getMetaDescriptionAttribute()
    {
        return $this->pageVersion()['meta_description'];
    }

    public function getMetaKeywordsAttribute()
    {
        return $this->pageVersion()['meta_keywords'];
    }

    public function getMetaImageAttribute()
    {
        return $this->pageVersion()['image'];
    }

    /*End table information*/

    public function pageVersions()
    {
        return is_null($this->versions) ? [] : $this->versions;
    }

    public function pageVersion()
    {
        return $this->versions[$this->version_id];
    }

    public function user()
    {
        return $this->belongsTo(Users::class, 'created_by');
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
        return [
            'slug' => ['name' => 'Slug', 'type' => 'text'],
            'versions[name]' => ['name' => 'Name', 'type' => 'text', 'as' => 'name'],
            'versions[title]' => ['name' => 'Title', 'type' => 'text', 'hidden' => 1, 'as' => 'title'],
            'versions[excerpt]' => ['name' => 'Excerpt', 'type' => 'text', 'hidden' => 1, 'as' => 'excerpt'],
            'versions[meta_description]' => ['name' => 'Meta description', 'type' => 'text', 'hidden' => 1, 'as' => 'meta_description'],
            'versions[meta_keywords]' => ['name' => 'Meta keywords', 'type' => 'text', 'hidden' => 1, 'as' => 'meta_keywords'],
            'layout' => ['name' => 'Layout', 'type' => 'select'],
            'user_id' => ['name' => 'Author', 'type' => 'select'],
            'type' => ['name' => 'Type', 'type' => 'select'],
            'status' => ['name' => 'Status', 'type' => 'select'],
            'versions[description]' => ['name' => 'Description', 'type' => 'textarea', 'hidden' => 1, 'as' => 'description'],
            'versions[content]' => ['name' => 'Content', 'type' => 'editor', 'hidden' => 1, 'as' => 'content'],
        ];
    }

    // Get Model name
    public function getModelName()
    {
        return 'Page';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'pages';
    }

    // Get name of the related model
    public function getRelatedName($related)
    {
        $pageVersion = $this->pageVersion();
        if($related === 'type') return $pageVersion['type']->snapshot()->value;
        else if($related === 'layout') return $pageVersion['layout']->snapshot()->value;
        else if($related === 'version') return $pageVersion['updated_at'];
        else if($related === 'status') return $this->lookupStatus()->value;
        else if($related === 'user_id') return $pageVersion['author']->snapshot()->name;
        else if($related === 'author_id') return $pageVersion['author']->snapshot()->name;
        else if($related === 'created_by') return $this->user()->name;
    }

    public function getSelect()
    {

        $select = ['types' => [], 'statuses' => [], 'layouts' => [], 'versions' => []];
        $data = ['types' => LookupValues::where('type', 'PAGE_TYPE'), 'statuses' => LookupValues::where('type', 'PAGE_STATUS'),
            'layouts' => LookupValues::where('type', 'PAGE_LAYOUT')];

        foreach ($data as $field => $model)
        {
            foreach($model->get() as $item)
            {
                $select[$field][$item->id] = $item->value ;
            }
        }

        foreach($this->pageVersions() as $k => $item)
        {
            $select['versions'][$k] = $item['name'].' '.$item['updated_at'].' ';
        }


        return [
            'type' => $select['types'],
            'status' => $select['statuses'],
            'layout' => $select['layouts'],
            'version' => $select['versions']
        ];
    }

    // Get related models before delete the model
    public function getChildren()
    {
        $children = [];
        return $children;
    }

    /*End model's methods*/
}
