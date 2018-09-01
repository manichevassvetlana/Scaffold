<?php

namespace App\Http\Controllers;

use App\Authorize;
use App\Notifications;
use App\Organizations;
use App\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function edit()
    {
        return view('organizations.editOrganization');
    }

    public function update($organization, Request $request)
    {
        $organization = Organizations::findOrFail($organization);

        Authorize::owner($organization);

        $organization->update([
            'name' => $request->name,
            'type' => $request->type
        ]);

        return redirect('/'); // TODO
    }

    public function leave(Request $request)
    {
        $user = fire_auth()->user();
        $user->update(['organization' => ['end_date' => Carbon::now(), 'status' => getLookupValue('ORG_USER_STATUS', 'Not Active')->id]]);
    }

    public function viewForOwner()
    {
        return view('organizations.setOwner');
    }

    public function setOwner()
    {
        $user = fire_auth()->user();
        $user->update(['organization' =>
            [
                'status' => getLookupValue('ORG_USER_STATUS', 'Active')->id,
                'type' => getLookupValue('ORG_USER_TYPE', 'Owner')->id
            ]]);

        return redirect('/'); // TODO
    }

    public function inviteOwner($organization, Request $request)
    {
        // TODO
    }

    public function confirmUser($user)
    {
        $org = fire_auth()->user()->getOrganizationByType('Owner');
        $orgUser = $org->users()->where('user_id', $user->id)->where('organization.status', getLookupValue('ORG_USER_STATUS', 'Pending')->id)->first();
        if ($org && $orgUser) $orgUser->update(['organization' => ['status' => getLookupValue('ORG_USER_STATUS', 'Active')->id]]);
        return back();
    }


    public static function sendNotifications($organization, $user, $owner)
    {
        $notifications = [
            [
                'user_id' => Users::admin()->id,
                'created_by' => Users::admin()->id,
                'icon' => 'fas fa-address-card',
                'body' => 'New user in the organization ' . $organization->name,
                'action_text' => 'Click here to manage',
                'action_url' => '/admin/users/' . $user->id . '/edit',
                'read' => 0
            ],
            [

                'user_id' => $owner->id,
                'created_by' => Users::admin()->id,
                'icon' => 'fas fa-address-card',
                'body' => 'New user ' . $user->email . ' in the organization ' . $organization->name,
                'action_text' => 'Click here to confirm',
                'action_url' => '/organization/user-confirm/' . $user->id,
                'read' => 0
            ]

        ];

        foreach ($notifications as $notification) {
            $notification = Notifications::create($notification);
        }
    }

    public static function addUserToOrganization($user, $org, $type)
    {
        $orgUser = $user->update([
            'organization' => [
                'id' => $org->id,
                'type' => getLookupValue('ORG_USER_TYPE', $type)->id,
                'status' => getLookupValue('ORG_USER_STATUS', 'Pending')->id,
                'start_date' => Carbon::now()
            ]
        ]);

        return $orgUser;
    }

    public static function addOrganization($domain, $user)
    {
        $org = Organizations::create([
            'name' => "Organization",
            'domain' => $domain,
            'type' => getLookupValue('ORG_TYPE', 'Personal')->id,
            'status' => getLookupValue('ORG_STATUS', 'Active')->id
        ]);

        OrganizationController::addUserToOrganization($user, $org, 'Owner');

        return $org;
    }
}
