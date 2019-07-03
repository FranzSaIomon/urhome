<?php

namespace App\Events;

use App\Conversation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ConversationCreated implements ShouldBroadCast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The id of the receiver.
     *
     * @var int
     */
    public $id;
    public $conversation;

    /**
     * Constructor.
     *
     * @param int $message
     */
    public function __construct($id, Conversation $conversation)
    {
        $this->id = $id;
        $this->conversation = $conversation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('conversation.creation.' . $this->id);
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'conversation.created';
    }

    public function broadcastWith()
    {
        return [
            "id" => $this->conversation->id,
            "User1" => $this->conversation->User1,
            "User2" => $this->conversation->User2,
            "user1" => $this->conversation->user1,
            "user2" => $this->conversation->user2
        ];
    }
}
