<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Startup extends Model
{
    // Define the table name if it differs from the pluralized model name (optional)
    // protected $table = 'startups';  // Uncomment if table name differs from default plural form of model

    // Define which fields are mass assignable (to prevent mass assignment vulnerabilities)
    protected $fillable = [
        'display_name',   // The name of the startup displayed to the user
        'logo',           // The filename of the logo image
        'creator_id',     // The ID of the user who created the startup
        'description',    // A brief description of the startup
        'industries',     // Comma-separated list of industries the startup operates in
        'funding_raised', // The amount of funding raised by the startup
    ];

    // Define attribute casting to automatically cast certain fields to specific types
    protected $casts = [
        'industries' => 'array',  // Automatically cast 'industries' to an array (assuming it's a JSON or comma-separated string)
    ];

    /**
     * Accessor for the 'industries' attribute.
     *
     * This method is used to clean and format the 'industries' field before it is returned
     * from the model. It strips any unwanted characters (like quotes or backslashes) and
     * splits the string into an array of industries.
     *
     * @param string $value
     * @return array
     */
    public function getIndustriesAttribute($value)
    {
        // Remove leading/trailing quotes and backslashes from the value
        $cleanedValue = stripslashes(trim($value, '"'));  // Strip any extra quotes and backslashes

        // Split the cleaned value by commas into an array and return it
        return explode(',', $cleanedValue); // Return array of industries
    }

    /**
     * Relationship: Get the user who created the startup.
     *
     * This defines the relationship between the Startup model and the User model.
     * Each startup has one creator (user).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function members()
    {
        return $this->hasMany(StartupMember::class);
    }

    // Additional attributes can be cast to specific types if needed
    // protected $casts = [
    //     'funding_raised' => 'integer',  // Cast 'funding_raised' to an integer
    // ];
}
