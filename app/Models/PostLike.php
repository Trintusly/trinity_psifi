<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'post_id',    // The ID of the post that is being liked
        'user_id',    // The ID of the user who liked the post
        'random_id'   // A unique identifier for the like (optional, can be used for additional tracking)
    ];

    /**
     * Relationship: Get the user who liked the post.
     *
     * This defines the relationship between the PostLike model and the User model.
     * Each like belongs to one user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
