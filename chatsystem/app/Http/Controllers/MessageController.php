<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        // Fetch all messages
        return Message::with('user')->get();
    }

    public function store(Request $request): Message
    {
        // Validate and store a new message
        $request->validate([
            'message' => 'required',
        ]);

        $message = new Message();
        $message->user_id = Auth::id();
        $message->message = $request->message;
        $message->save();

        event(new MessageSent($request->message));

        return $message;
    }
}
