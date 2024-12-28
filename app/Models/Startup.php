<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Startup extends Model
{
    // Define the table name if it differs from the pluralized model name (optional)
    // protected $table = 'startups';

    // Define which fields are mass assignable
    protected $fillable = [
        'display_name',
        'logo',
        'creator_id',
        'description',
        'industries',
        'funding_raised',
    ];
    protected $casts = [
        'industries' => 'array',  // Automatically cast to an array
    ];

    public function getIndustriesAttribute($value)
    {
        // Split the string by commas and trim each value to remove spaces
        // Remove extra quotes and backslashes
        $cleanedValue = stripslashes(trim($value, '"')); // Remove leading/trailing quotes and backslashes

        // Now split by commas, just in case there are multiple industries
        return explode(',', $cleanedValue);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    
    
    // If you need to cast some attributes to specific types (like integers or dates)
    // protected $casts = [
    //     'funding_raised' => 'integer',
    // ];
}
