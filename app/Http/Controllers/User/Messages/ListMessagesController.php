<?php

namespace App\Http\Controllers\User\Messages;

use App\Http\Controllers\Controller;

class ListMessagesController extends Controller
{
    /**
     * Display a list of user messages (received or sent).
     *
     * @param string $show Filter to determine whether to show 'received' or 'sent' messages.
     * @return \Illuminate\View\View The view displaying the messages list.
     */
    public function index($show = 'received')
    {
        // Determine which set of messages to fetch based on the $show parameter
        $messages = $show === 'sent'
            ? auth()->user()->messagesSent()->latest()->paginate(15) // Fetch sent messages
            : auth()->user()->messagesReceived()->latest()->paginate(15); // Fetch received messages

        // Count unread received messages
        $unreadCount = auth()->user()->messagesReceived()
            ->where('read', 0)
            ->count();

        // Return the messages list view with relevant data
        return view('user.messages.list', [
            'show' => $show,       // Indicator for received or sent messages
            'messages' => $messages, // Paginated messages
            'unread' => $unreadCount, // Count of unread messages
        ]);
    }
}
