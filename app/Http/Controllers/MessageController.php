<?php

namespace App\Http\Controllers;

use App\Message;
use App\Events\MessagePOsted;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function send(Request $request) {
        event(new MessagePosted("LOL"));
    }
}
