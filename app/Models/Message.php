<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Message extends Model
{
    protected $fillable = [
        'receiver_id',
        'sender_id',
        'is_reply',
        'reply_to',
        'read',
        'title',
        'body',
    ];

    /**
     * Relationship: Get the sender of the message.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Relationship: Get the receiver of the message.
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Retrieve sender account data.
     */
    public function getSenderAccountData()
    {
        return $this->sender()->first();
    }

    /**
     * Retrieve receiver account data.
     */
    public function getReceiverAccountData()
    {
        return $this->receiver()->first();
    }
}
