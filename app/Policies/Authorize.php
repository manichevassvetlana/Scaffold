<?php

namespace App;

use Google\Cloud\Firestore\DocumentSnapshot;
use Illuminate\Auth\Access\AuthorizationException;

class Authorize
{
    private $user;

    public function __construct()
    {
        $this->user = fire_auth()->user();
    }

    public function ownerOrganization(Organizations $organization)
    {
        return $organization->getOwner()->id == $this->user->id;
    }

    public function ownerNotification(Notifications $notification)
    {
        return $notification->user_id == $this->user->id;
    }

    public function ownerAnnouncement(Announcements $announcement)
    {
        return $announcement->user_id == $this->user->id;
    }

    public static function __callStatic($name, $argument)
    {
        $authorize = new Authorize();
        if(is_array($argument)) $argument = $argument[0];
        if($name == 'owner' && $argument instanceof DocumentSnapshot){
            switch ($argument) {
                case get_class($argument) === 'App\Organizations' :
                    return $authorize->ownerOrganization($argument) ? true : $authorize->deny();
                case get_class($argument) === 'App\Notifications' :
                    return $authorize->ownerNotification($argument) ? true : $authorize->deny();
                case get_class($argument) === 'App\Announcements' :
                    return $authorize->ownerAnnouncement($argument) ? true : $authorize->deny();
            }
        }
        return $authorize->deny();
    }

    protected function deny($message = 'This action is unauthorized.')
    {
        throw new AuthorizationException($message);
    }
}
