<?php

namespace App\Http\Controllers;

use App\User;
use App\Log;
use App\Conversation;
use App\Message;
use App\Events\MessagePosted;
use App\Events\ConversationCreated;
use App\Events\ConversationUnread;
use Illuminate\Http\Request;

use App\BrokerInformation;
class ConversationController extends Controller
{
    public function create_conversation(Request $request, User $user) {
        if (auth()->check() && isset($user)) {
            if ($user->id != auth()->id()) {
                $message = new Message();
                $check_conversation = Conversation::where('User1', auth()->id())->where('User2', $user->id)->first();
                $check_conversation2 = Conversation::where('User2', auth()->id())->where('User1', $user->id)->first();

                if (!isset($check_conversation) && !isset($check_conversation2)) {
                    $conversation = new Conversation();
                    $conversation->User1 = auth()->user()->id;
                    $conversation->User2 = $user->id;
                    
                    $conversation->save();
                    event(new ConversationCreated($user->id, $conversation));
                    event(new ConversationUnread($user->id));

                    $message->content = "Hi!";
                    $message->user_id = auth()->user()->id;
                    $message->conversation_id = $conversation->id;
                    $message->save();
                    event(new MessagePosted($message));
                    
                    Log::log(auth()->id(), "User {" . auth()->id() . "} started a conversation with User {" . $user->id . "}");
                    return response()->json();
                } else if (isset($check_conversation)) {
                    $receiver = ($check_conversation->User1 == auth()->id()) ? $check_conversation->User2 : $check_conversation->User1;
                    $message->content = "Hi!";
                    $message->user_id = auth()->user()->id;
                    $message->conversation_id = $check_conversation->id;

                    $message->save();
                    
                    event(new MessagePosted($message));
                    event(new ConversationUnread($receiver));
                    return response()->json(['success' => true]);
                } else if (isset($check_conversation2)) {
                    $receiver = ($check_conversation2->User1 == auth()->id()) ? $check_conversation2->User2 : $check_conversation2->User1;
                    $message->content = "Hi!";
                    $message->user_id = auth()->user()->id;
                    $message->conversation_id = $check_conversation2->id;
                    $message->save();
                    
                    event(new MessagePosted($message));
                    event(new ConversationUnread($receiver));
                    return response()->json(['success' => true]);
                }
            }
        }
    }

    public function get_conversations(Request $request) {
        $user = null;
        if (isset($request['id']) && $request['id'] != null)
            $user = User::find(intval($request['id']))->first();

        if (auth()->check()) {
            $conversations = [];
            $check0 = null;
            $check1 = null;
            
            if (isset($user)) {
                $check0 = Conversation::with(['user1', 'user2'])->where('User1', auth()->id())->where('User2', $user->id)->first();
                $check1 = Conversation::with(['user1', 'user2'])->where('User2', auth()->id())->where('User1', $user->id)->first();

                if (isset($check0)) {
                    array_push($conversations, $check0);
                } else if (isset($check1)) {
                    array_push($conversations, $check1);
                }
            }

            if (isset($check0) || isset($check1)) {
                $check0 = Conversation::with(['user1', 'user2'])->where('User1', auth()->id())->where('id', '<>', $conversations[0]->id)->get();
                $check1 = Conversation::with(['user1', 'user2'])->where('User2', auth()->id())->where('id', '<>', $conversations[0]->id)->get();
            } else {
                $check0 = Conversation::with(['user1', 'user2'])->where('User1', auth()->id())->get();
                $check1 = Conversation::with(['user1', 'user2'])->where('User2', auth()->id())->get();
            }

            for ($i = 0; $i < count($check0); $i++) array_push($conversations, $check0[$i]);
            for ($i = 0; $i < count($check1); $i++) array_push($conversations, $check1[$i]);

            return $conversations;
        }
    }

    public function get_messages(Request $request, Conversation $conv) {
        $messages = null;

        if (auth()->check() && isset($conv) && ($conv->User1 == auth()->id()  || $conv->User2 == auth()->id())) {
            $messages = Message::with('user')->where('conversation_id', $conv->id)->orderBy('created_at', 'DESC');
        }

        return $messages;
    }

    public function paginate_messages(Request $request, Conversation $conv) {
        $messages = $this->get_messages($request, $conv);

        if ($messages != null) {
            $messages = $messages->paginate(15);
            for($i = 0; $i < count($messages->items()); $i++) {
                if ($messages[$i]->user->id != auth()->id() && (!isset($messages->items()[$i]->read_at) || $messages->items()[$i]->read_at != null)) {
                    $messages->items()[$i]->read_at = date('Y-m-d G:i:s');
                    $messages->items()[$i]->save();
                }
            }

            return $messages;
        }

        return [];
    }

    public function send(Request $request, Conversation $conversation) {
        $request->validate([
            'content' => 'filled'
        ]);

        $receiver = ($conversation->User1 == auth()->id()) ? $conversation->User2 : $conversation->User1;
        $message = new Message();
        $message->content = $request['content'];
        $message->conversation_id = $conversation->id;
        $message->user_id = auth()->id();

        $message->save();

        event(new MessagePosted($message));
        event(new ConversationUnread($receiver));
        return $message;
    }

    public function read(Request $request, Message $msg) {
        if (auth()->id() != $msg->user->id) {
            $msg->read_at = date('Y-m-d G:i:s');
            $msg->save();
        }
    }

    public function count_new_conversations(Request $request, User $user) {
        $q = Conversation::join('messages', function ($join) use ($user) {
            $join->on('messages.conversation_id', 'conversations.id');
        })->where('messages.read_at', null)->where('messages.user_id', '!=', $user->id)
        ->where(function ($q) use ($user) {
            $q->orWhere('User1', $user->id)
            ->orWhere('User2', $user->id);
        });

        return $q->count();
    }
}
