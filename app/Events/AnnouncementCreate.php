<?php

namespace App\Events;

use App\Announcement;
use App\Announcements;
use App\Notification;
use Google\Cloud\Firestore\DocumentSnapshot;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AnnouncementCreate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $announcement;


    public function __construct(DocumentSnapshot $announcement)
    {
        $this->announcement = $announcement;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('announcement');
    }
}
