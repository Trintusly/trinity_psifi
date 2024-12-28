<?php

namespace App\Http\Controllers\User\Messages;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Messages\SendMessageRequest;
use App\Models\User;
use Illuminate\Http\Request;

class SendMessageController extends Controller
{
    public function index($username)
    {
        $user = User::where(["username" => $username])->firstOrFail();

        return view(
            "user.messages.send",
            ["user" => $user]
        );
    }

    public function send(SendMessageRequest $sendMessageRequest, $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        // Prepare the message data
        $messageData = [
            'receiver_id' => $user->id,
            'title' => $sendMessageRequest->title,
            'body' => $sendMessageRequest->body,
        ];

        // Check if reply_to exists in the request
        if ($sendMessageRequest->filled('reply_to')) {
            $messageData['reply_to'] = $sendMessageRequest->reply_to;
            $messageData['is_reply'] = 1;
        }

        // Create the message
        $m = auth()->user()->messagesSent()->create($messageData);

        return redirect()->route('user.messages.view', [$m->id]);
    }

}
