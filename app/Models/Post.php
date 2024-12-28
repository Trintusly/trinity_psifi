<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'body',       // The content of the post
        'image',      // URL or path to the post's image
        'is_share',   // A flag indicating if the post is a shared post
        'share_of',   // The ID of the original post if this is a shared post
    ];

    /**
     * Parse BBCode to HTML
     *
     * This method takes a BBCode string and converts its syntax into HTML.
     * It supports basic BBCode tags such as [b], [i], [u], [url], and [img].
     * 
     * @param string $bbcode
     * @return string
     */
    public static function parseBBCode($bbcode)
    {
        // Replace [b] and [/b] tags with <strong> and </strong>
        $bbcode = preg_replace('/\[b\](.*?)\[\/b\]/is', '<strong>$1</strong>', $bbcode);

        // Replace [i] and [/i] tags with <em> and </em>
        $bbcode = preg_replace('/\[i\](.*?)\[\/i\]/is', '<em>$1</em>', $bbcode);

        // Replace [u] and [/u] tags with <u> and </u>
        $bbcode = preg_replace('/\[u\](.*?)\[\/u\]/is', '<u>$1</u>', $bbcode);

        // Replace [url] and [/url] tags with anchor tags
        $bbcode = preg_replace('/\[url=(.*?)\](.*?)\[\/url\]/is', '<a href="$1">$2</a>', $bbcode);

        // Replace [img] and [/img] tags with <img> tag
        $bbcode = preg_replace('/\[img\](.*?)\[\/img\]/is', '<img src="$1" alt="Image">', $bbcode);

        // Additional parsing rules can be added as needed

        // Strip any HTML tags that are not allowed (i.e., disallowing any tags except <strong>, <em>, <u>, <a>, and <br>)
        return strip_tags($bbcode, '<strong><em><u><a><br>');
    }

    /**
     * Relationship: Get the user who created the post.
     *
     * This defines the relationship between the post and the user who created it.
     * Each post belongs to one user.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Get the comments for the post.
     *
     * This defines the relationship between the post and its comments.
     * A post can have many comments.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Relationship: Get the users who liked the post.
     *
     * This defines the many-to-many relationship between the post and users who liked it.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_likes')->withTimestamps();
    }

    /**
     * Check if the post is liked by a specific user.
     *
     * This method checks whether a particular user has liked the post.
     * 
     * @param \App\Models\User $user
     * @return bool
     */
    public function likedByUser($user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }

    /**
     * Relationship: Get the original post if this is a shared post.
     *
     * This defines the relationship for posts that are shares. It links the shared post to its original post.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function originalPost()
    {
        return $this->belongsTo(Post::class, 'share_of');
    }

    /**
     * Relationship: Get the original post and its user if this is a shared post.
     *
     * This is a variation of the original post relationship that also loads the user who created the original post.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function originalPostUser()
    {
        return $this->belongsTo(Post::class, 'share_of')->with('user');
    }
}
