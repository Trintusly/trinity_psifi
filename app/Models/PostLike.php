<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    protected $fillable = [
        'post_id',
        'user_id',
        'random_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
