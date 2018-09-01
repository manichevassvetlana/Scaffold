<?php

namespace App\Events;

use App\Notification;
use App\Notifications;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationCreate implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;


    public function __construct(Notifications $notification)
    {
        $this->notification = $notification;
    }


    public function broadcastOn()
    {
        return new PrivateChannel('notify');
    }
}
