<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StartupMember extends Model
{
    protected $table = 'startup_members'; // Table name

    protected $fillable = ['startup_id', 'user_id', 'role']; // Allow mass assignment

    // Define relationships if needed

    public function startup()
    {
        return $this->belongsTo(Startup::class); // Each member belongs to one startup
    }

    public function user()
    {
        return $this->belongsTo(User::class); // Each member belongs to one user
    }
}
