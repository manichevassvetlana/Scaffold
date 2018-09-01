<?php

namespace App\Policies;

use App\Announcement;
use App\Announcements;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnnouncementPolicy
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

    public function owner(User $user, Announcements $announcement)
    {
        return $announcement->user_id == $user->id;
    }


}
