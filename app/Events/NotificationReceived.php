<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class NotificationReceived implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    private $usersChannels;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($message, $users)
    {
        $this->message = $message;
        $this->usersChannels = [];
        foreach ($users as $user) {
            $common = 'notification-received-channel-';
            array_push($this->usersChannels, $common . $user->username);
        }
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return $this->usersChannels;
    }

    public function broadcastAs()
    {
        return 'notification-received';
    }
}
