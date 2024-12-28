<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StartupMember extends Model
{
    // Define the custom table name, if it differs from the pluralized model name
    protected $table = 'startup_members';  // Table name in the database

    // Define which fields are mass assignable (to protect against mass assignment vulnerabilities)
    protected $fillable = [
        'startup_id', // The ID of the startup to which the member belongs
        'user_id',    // The ID of the user who is the member
        'role',       // The role of the member in the startup (e.g., "Founder", "Developer", etc.)
    ];

    /**
     * Relationship: Get the startup this member belongs to.
     *
     * Defines the relationship between the StartupMember model and the Startup model.
     * Each startup member belongs to one startup.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function startup()
    {
        return $this->belongsTo(Startup::class); // Each member belongs to a startup
    }

    /**
     * Relationship: Get the user who is the member of the startup.
     *
     * Defines the relationship between the StartupMember model and the User model.
     * Each startup member belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class); // Each member belongs to a user
    }
}
