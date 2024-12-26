<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'body',
        'image',
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


}
