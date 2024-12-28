<?php

namespace App\Http\Controllers\User\Messages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ListMessagesController extends Controller
{
    public function index($show = 'received')
    {
        // Fetch messages based on the $show value ('received' or 'sent')
        $messages = $show === 'sent'
            ? auth()->user()->messagesSent()->latest()->paginate(15)  // Fetch sent messages
            : auth()->user()->messagesReceived()->latest()->paginate(15);  // Fetch received messages
        $unreadCount = auth()->user()->messagesReceived()
            ->where('read', 0)
            ->count();
        // Return the view with the messages and show parameter
        return view("user.messages.list", [
            "show" => $show,
            "messages" => $messages,
            "unread" => $unreadCount
        ]);
    }
}
