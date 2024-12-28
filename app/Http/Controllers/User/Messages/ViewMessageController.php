<?php

namespace App\Http\Controllers\User\Messages;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class ViewMessageController extends Controller
{
    public function index($id)
    {
        // Find the message by ID
        $message = Message::findOrFail($id);

        // Check if the authenticated user is the sender or the receiver of the message
        if ($message->receiver_id != auth()->id() && $message->sender_id != auth()->id()) {
            // If the user is neither the sender nor the receiver, return a 403 response
            abort(403, 'You are not authorized to view this message.');
        }

        // Mark the message as read if the receiver is viewing the message
        if ($message->receiver_id == auth()->id() && !$message->read) {
            $message->update(['read' => true]);
        }

        // Return the message to the view
        return view("user.messages.view", ["message" => $message]);
    }
}
