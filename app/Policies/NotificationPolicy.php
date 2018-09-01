<?php

namespace App\Policies;

use App\Notification;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;


    public function __construct()
    {
        //
    }

    public function owner(User $user, Notification $notification)
    {
        return $notification->user_id == $user->id;
    }
}
