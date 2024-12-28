<?php

namespace App\Http\Controllers\User\Messages;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Messages\SendMessageRequest;
use App\Models\User;

class SendMessageController extends Controller
{
    /**
     * Show the message send form for the specified user.
     *
     * @param string $username The username of the recipient.
     * @return \Illuminate\View\View The view for sending a message.
     */
    public function index($username)
    {
        // Retrieve the user by username or throw a 404 if not found
        $user = User::where('username', $username)->firstOrFail();

        // Return the view for composing a message, passing the recipient user
        return view('user.messages.send', [
            'user' => $user,
        ]);
    }

    /**
     * Handle sending a message to the specified user.
     *
     * @param SendMessageRequest $sendMessageRequest The validated message data.
     * @param string $username The username of the recipient.
     * @return \Illuminate\Http\RedirectResponse Redirect to the message view page.
     */
    public function send(SendMessageRequest $sendMessageRequest, $username)
    {
        // Retrieve the user by username or throw a 404 if not found
        $user = User::where('username', $username)->firstOrFail();

        // Prepare the message data to be sent
        $messageData = [
            'receiver_id' => $user->id,
            'title' => $sendMessageRequest->title,
            'body' => $sendMessageRequest->body,
        ];

        // Check if a reply_to field is provided and add it to the message data
        if ($sendMessageRequest->filled('reply_to')) {
            $messageData['reply_to'] = $sendMessageRequest->reply_to;
            $messageData['is_reply'] = 1; // Mark as a reply
        }

        // Create the message and associate it with the authenticated user
        $message = auth()->user()->messagesSent()->create($messageData);

        // Redirect to the view page for the newly created message
        return redirect()->route('user.messages.view', [$message->id]);
    }
}
