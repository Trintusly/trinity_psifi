<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    // Use HasFactory for model factories and Notifiable for notifications
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * These attributes can be mass-assigned using methods like create or update.
     * Always ensure that these fields are safe for mass assignment.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',  // User's username
        'email',     // User's email address
        'password',  // User's hashed password
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * These attributes will not be visible when the model is converted to an array or JSON.
     * This is done for sensitive data like the password and remember token.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',       // The user's password (never exposed in responses)
        'remember_token', // The token used to remember the user session (shouldn't be exposed)
    ];

    /**
     * The attributes that should be cast.
     *
     * This allows you to automatically cast certain attributes to specific types when the model is accessed.
     * For instance, dates can be cast to instances of Carbon, and strings can be hashed automatically.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime', // Cast the email_verified_at field to a datetime instance
            'password' => 'hashed',           // Ensure the password is always returned as a hashed value
        ];
    }

    /**
     * Relationship: Get all posts created by the user.
     *
     * A user can have many posts. This is a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Relationship: Get all post likes associated with the user.
     *
     * A user can have many post likes. This relationship tracks the posts the user has liked.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function postLikes()
    {
        return $this->hasMany(PostLike::class);
    }

    /**
     * Relationship: Get all comments made by the user.
     *
     * A user can have many comments. This is a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Relationship: Get all messages sent by the user.
     *
     * A user can send many messages. This is a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messagesSent()
    {
        return $this->hasMany(Message::class, "sender_id");
    }

    /**
     * Relationship: Get all messages received by the user.
     *
     * A user can receive many messages. This is a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messagesReceived()
    {
        return $this->hasMany(Message::class, "receiver_id");
    }

    /**
     * Relationship: Get all startups created by the user.
     *
     * A user can create many startups. This is a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function startups()
    {
        return $this->hasMany(Startup::class, 'creator_id');
    }

    /**
     * Relationship: Get all startup memberships the user is part of.
     *
     * A user can be part of many startups through the `startup_members` table. This is a one-to-many relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function startupMembers()
    {
        return $this->hasMany(StartupMember::class);
    }

    public function primaryStartup()
    {
        // Check if the user has a primary startup set
        if ($this->primary_startup) {
            // Return the associated Startup model
            return Startup::find($this->primary_startup);
        }

        // Return null if no primary startup is set
        return null;
    }
    public function joinRequests()
    {
        return $this->hasMany(StartupJoinRequest::class, 'user_id');
    }
}
