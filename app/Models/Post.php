<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'body',
        'image',
        'is_share',
        'share_of',
    ];

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

        return strip_tags($bbcode, '<strong><em><u><a><br>');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function likes()
    {
        return $this->belongsToMany(User::class, 'post_likes')->withTimestamps();
    }
    
    // In the Post model
    public function likedByUser($user)
    {
        // Assuming the relationship between User and Post is many-to-many via a pivot table (e.g., post_likes)
        return $this->likes()->where('user_id', $user->id)->exists();
    }


    public function originalPost()
    {
        return $this->belongsTo(Post::class, 'share_of');
    }
    public function originalPostUser()
    {
        return $this->belongsTo(Post::class, 'share_of')->with('user');
    }
}
