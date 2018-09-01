<?php

namespace App;

use Symfony\Component\Debug\Exception\FatalThrowableError;
use WebsolutionsGroup\Firestore\DocumentSnapshot;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Lab404\Impersonate\Services\ImpersonateManager;
use Laravel\Cashier\Billable;
use Laravel\Passport\HasApiTokens;

class Users extends DocumentSnapshot
{
    use Notifiable, Impersonate, HasApiTokens, Billable;

    /*Table information*/

    // The attributes that are mass assignable.
    protected $fillable = [
        'name', 'email', 'active', 'image', 'roles', 'organization' => ['id', 'type', 'status', 'start_date', 'end_date', 'roles']
    ];

    public $isRemovable = true;

    public $searchField = 'email';

    /*End table information*/

    public function pages()
    {
        return $this->hasMany(Pages::class, 'created_by');
    }

    public function documents()
    {
        return $this->hasMany(Documents::class, 'author_id');
    }

    public function developers()
    {
        return $this->hasMany(Developers::class, 'user_id');
    }

    public function organizationType()
    {
        return LookupValues::find($this->organization["type"]);
    }

    public function organizationStatus()
    {
        return LookupValues::find($this->organization["status"]);
    }

    public function organization()
    {
        return Organizations::find($this->organization["id"]);
    }

    public function userNotifications()
    {
        return $this->hasMany(Notifications::class, 'user_id');
    }

    public function userAnnouncements()
    {
        return $this->hasMany(Announcements::class, 'user_id');
    }

    public function morphDocuments()
    {
        return $this->morphMany(Documents::class, 'reference');
    }

    /*Model's methods*/

    public function getPivot($pivot, $element)
    {
        try{
            $response = in_references($element->reference()->name(), $this->$pivot);
            return $response;
        }
        catch (\Exception $e){
            dd($element);
        }
    }

    // Get Model fields for CRUD operations in view
    public function getFields()
    {
        $fields = [
            'name' => ['name' => 'Name', 'type' => 'text'],
            'email' => ['name' => 'Email', 'type' => 'text'],
            'password' => ['name' => 'Password', 'type' => 'password', 'hidden' => 1],
            'active' => ['name' => 'Active', 'type' => 'checkbox'],
            'imperson' => ['name' => 'Impersonate', 'type' => 'imperson', 'editable' => 0],
            'roles' => ['name' => 'Roles', 'type' => 'new-pivot', 'elements' => Roles::where('type', getLookupValue('ROLE_TYPE', 'User')->id)->get(), 'hidden' => 1],
            'organization' => ['name' => 'Organization', 'type' => 'user-organization', 'elements' => [
                'id' => ['name' => 'Organization Name', 'type' => 'select', 'values' => Organizations::all()],
                'type' => ['name' => 'Type', 'type' => 'select', 'values' => LookupValues::where('type', 'ORG_USER_TYPE')->get()],
                'status' => ['name' => 'Status', 'type' => 'select', 'values' => LookupValues::where('type', 'ORG_USER_STATUS')->get()],
                'start_date' => ['name' => 'Start Date', 'type' => 'datetime'],
                'end_date' => ['name' => 'End Date', 'type' => 'datetime'],
            ], 'hidden' => 1],
        ];
        if(!is_null($this->organization())) $fields['roles_id'] = ['name' => 'Organization Roles', 'type' => 'pivot-ajax', 'div' => 'pivot-roles', 'hidden' => 1, 'pivot' => 'organizationRoles', 'header' => [
           'role_name' => 'Role', 'start_date' => 'Date Start', 'end_date' => 'Date End']];
        return $fields;
    }

    // Get Model name
    public function getModelName()
    {
        return 'User';
    }

    // Get name of the route for the model
    public function getRouteName()
    {
        return 'users';
    }

    // Notifications for user
    public function getUnreadNotifications()
    {
        return $this->userNotifications()->where('read', false)->get();
    }

    // Announcements for user
    public function getUnreadAnnouncements()
    {
        return $this->userAnnouncements()->where('read', false)->get();
    }

    // Get global admin user
    public static function admin()
    {
        return Users::where('email', 'admin@websolutions-group.com')->first();
    }

    public function getOrganizationByType($type)
    {
        return !is_null($this->organization) ? $orgUser = $this->organization['type'] == getLookupValue('ORG_USER_TYPE', $type)->id ? $this->organization() : false : $orgUser = false;
    }

    public function getOrganizationByStatus($status)
    {
        return !is_null($this->organization) ? $orgUser = $this->organization['status'] == getLookupValue('ORG_USER_STATUS', $status)->id ? $this->organization() : false : $orgUser = false;
    }

    public function isRole($role)
    {
        $role = Roles::where('name', $role)->first();
        return !is_null($this->roles) && !is_null($role) ? in_array($role->id, is_array($this->roles) ? $this->roles : []) : false;
    }

    public function getRole()
    {
        return $this->isRole('Admin') ? 'admin' : 'user';
    }

    public function isGlobalAdmin()
    {
        return $this->id == $this->where('email', 'admin@websolutions-group.com')->first()->id;
    }

    public function canImpersonate()
    {
        return $this->isGlobalAdmin();
    }

    public function canBeImpersonated()
    {
        return !$this->isGlobalAdmin();
    }

    public function isImpersonated()
    {
        return app(ImpersonateManager::class)->isImpersonating();
    }

    // Get related models before delete the model
    public function getChildren()
    {
        $relations = [$this->userAnnouncements(), $this->developers(), $this->documents(), $this->userNotifications(),
            $this->pageVersions(), $this->pages()];
        $children = [];
        foreach ($relations as $k => $child){
            $children[$k] = [
                'model' => $child,
                'message' => 'There are records in other tables that relate to this user. Do you want to delete user with all dependencies?',
                'path' => '/admin/users/'.$this->id.'-remove'
            ];
        }
        return $children;
    }

    // Get name of the related model
    public function getRelatedName($related)
    {
        if ($related === 'id') return $this->organization()->name;
        else if ($related === 'type') return $this->organizationType()->value;
        else if ($related === 'status') return $this->organizationType()->status;
    }

    public function getOrganizationRoles()
    {
        return is_null($this->organization()) ? [] : $this->organization()->roles;
    }

    /*End model's methods*/
}
