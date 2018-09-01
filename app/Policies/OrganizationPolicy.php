<?php

namespace App\Policies;

use App\Organizations;
use App\Users;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function owner(Users $user, Organizations $organization)
    {
        return $organization->getOwner()->id == $user->id;
    }
}
