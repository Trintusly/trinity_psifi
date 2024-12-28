<?php

namespace App\Http\Controllers\Startup;

use App\Http\Controllers\Controller;

class ListStartupController extends Controller
{
    /**
     * Display a paginated list of startups owned by the authenticated user.
     *
     * @return \Illuminate\View\View The view displaying the list of startups.
     */
    public function index()
    {
        // Fetch startups associated with the authenticated user,
        // ordered by the latest first, and paginated (15 per page).
        $startups = auth()->user()
            ->startups()
            ->latest()
            ->paginate(15);

        // Pass the startups collection to the view
        return view('startup.list', [
            'startups' => $startups,
        ]);
    }
}
