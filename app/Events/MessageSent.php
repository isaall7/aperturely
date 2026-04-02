<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;

class MessageSent implements ShouldBroadcastNow
    {
        public $message;

        public function __construct($message)
        {
            $this->message = $message;
        }

        public function broadcastOn()
        {
            return new PrivateChannel('chat.' . $this->message->conversation_id);
        }

        public function broadcastAs()
        {
            return 'message.sent';
        }
    }
