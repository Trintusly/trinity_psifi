<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Startup;

class SearchController extends Controller
{
    /**
     * Display the search page or results based on query parameters.
     */
    public function index(Request $request)
    {
        $type = $request->input('type');
        $query = $request->input('query');

        // If no search parameters, return the search page
        if (!$type || !$query) {
            return view('search');
        }

        // Validate input
        $request->validate([
            'type' => 'required|in:user,startup',
            'query' => 'required|string|min:1'
        ]);

        // Perform search based on type
        if ($type === 'user') {
            $results = User::where('username', 'LIKE', "%{$query}%")->get();
        } elseif ($type === 'startup') {
            $results = Startup::where('display_name', 'LIKE', "%{$query}%")
                ->orWhere('industries', 'LIKE', "%{$query}%")
                ->get();
        } else {
            $results = collect(); // Empty collection as fallback
        }

        return view('search', [
            'results' => $results,
            'type' => $type,
            'query' => $query
        ]);
    }
}
