<?php

namespace App\Broadcasting;

use App\Models\Conversation;
use App\User;

class ConversationChannel
{
     /**
     * Authenticate the user's access to the channel.
     *
     * @param User         $user
     * @param Conversation $conversation
     *
     * @return array|bool
     */
    public function join(User $user, Conversation $conversation)
    {
        return $conversation->user1->id == $user->id || $conversation->user2->id == $user->id;
    }
}
