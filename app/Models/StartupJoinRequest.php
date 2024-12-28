<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StartupJoinRequest extends Model
{
    // Define the table if it differs from the pluralized model name (optional)
    // protected $table = 'startup_join_requests';

    // Define which attributes are mass assignable
    protected $fillable = [
        'user_id',
        'startup_id',
    ];

    /**
     * Get the user that owns the join request.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the startup that the user is requesting to join.
     */
    public function startup()
    {
        return $this->belongsTo(Startup::class, 'startup_id');
    }
}
