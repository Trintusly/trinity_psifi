<?php

namespace App\Http\Controllers\User\Messages;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class ViewMessageController extends Controller
{
    /**
     * Display the details of a specific message.
     *
     * @param int $id The ID of the message to view.
     * @return \Illuminate\View\View The view displaying the message details.
     * @throws \Illuminate\Auth\Access\AuthorizationException If the user is not authorized to view the message.
     */
    public function index($id)
    {
        // Find the message by ID or throw a 404 error if not found
        $message = Message::findOrFail($id);

        // Check if the authenticated user is either the sender or the receiver of the message
        if ($message->receiver_id != auth()->id() && $message->sender_id != auth()->id()) {
            // If the user is neither the sender nor the receiver, abort with a 403 error
            abort(403, 'You are not authorized to view this message.');
        }

        // Mark the message as read if the authenticated user is the receiver and it is unread
        if ($message->receiver_id == auth()->id() && !$message->read) {
            $message->update(['read' => true]);
        }

        // Return the message view with the message data
        return view('user.messages.view', [
            'message' => $message
        ]);
    }
}
