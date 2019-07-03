<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/
use App\Broadcasting\ConversationChannel;
use App\Conversation;

Broadcast::channel('conversation.unread.{user}', function (User $user) {
    return true;
});

Broadcast::channel('conversation.notification.{user}', function (User $user) {
    return true;
});

Broadcast::channel('conversation.creation.{user}', function (User $user) {
    return true;
});

Broadcast::channel('conversation.{conversation}', function (User $user, Conversation $conversation) {
    return $conversation->User1 === $user->id || $conversation->User2 === $user->id;
});


Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
