<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Message extends Model
{
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'receiver_id',  // The ID of the user receiving the message
        'sender_id',    // The ID of the user sending the message
        'is_reply',     // A flag indicating if the message is a reply
        'reply_to',     // The ID of the message this is replying to (if applicable)
        'read',         // A flag indicating whether the message has been read
        'title',        // The title of the message
        'body',         // The body content of the message
    ];

    /**
     * Relationship: Get the sender of the message.
     *
     * This defines the relationship between the message and the user who sent it.
     * Each message belongs to one sender.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Relationship: Get the receiver of the message.
     *
     * This defines the relationship between the message and the user who receives it.
     * Each message belongs to one receiver.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Retrieve sender account data.
     *
     * This function retrieves the account data of the sender by loading the sender relationship and fetching the first result.
     * 
     * @return \App\Models\User
     */
    public function getSenderAccountData()
    {
        return $this->sender()->first();
    }

    /**
     * Retrieve receiver account data.
     *
     * This function retrieves the account data of the receiver by loading the receiver relationship and fetching the first result.
     * 
     * @return \App\Models\User
     */
    public function getReceiverAccountData()
    {
        return $this->receiver()->first();
    }
}
