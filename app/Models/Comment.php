<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    // Define the fillable attributes for mass assignment
    protected $fillable = ['user_id', 'post_id', 'body'];

    /**
     * Get the user who made the comment.
     *
     * This defines the relationship between a comment and its author (User).
     * Each comment belongs to one user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the post associated with the comment.
     *
     * This defines the relationship between a comment and the post it belongs to.
     * Each comment is associated with one post.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
