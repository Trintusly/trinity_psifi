<?php

namespace App\Http\Controllers\Startup;

use App\Http\Controllers\Controller;
use App\Models\Startup;
use App\Models\StartupJoinRequest;
use App\Models\StartupMember;
use Illuminate\Http\Request;

class ManageStartupController extends Controller
{
    /**
     * Display the startup management list view.
     *
     * @return \Illuminate\View\View The view for managing startups.
     */
    public function index($id)
    {
        $startup = Startup::findOrFail($id);

        // Check if the authenticated user is a member of the startup and has the right role
        $isMember = auth()->user()->startupMembers()->where('startup_id', $startup->id)->exists();
        $hasRole = auth()->user()->startupMembers()
            ->where('startup_id', $startup->id)
            ->whereIn('role', ['OWNER', 'EDITOR'])
            ->exists();

        if (!$isMember || !$hasRole) {
            return redirect()->route('home')->with('error', 'You do not have the necessary permissions to manage this startup.');
        }

        // Get the list of pending join requests
        $pendingRequests = StartupJoinRequest::where('startup_id', $startup->id)
            ->get(); // All pending requests in the table, no need to filter by status

        // Render the startup management list view with pending requests
        return view('startup.manage', [
            'startup' => $startup,
            'pendingRequests' => $pendingRequests
        ]);
    }

    /**
     * Accept a join request and assign a role.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $startupId
     * @param int $requestId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function acceptRequest(Request $request, $startupId, $requestId)
    {
        // Retrieve the startup and join request
        $startup = Startup::findOrFail($startupId);
        $joinRequest = StartupJoinRequest::findOrFail($requestId);

        // Check if the user is authorized to manage this startup
        $isMember = auth()->user()->startupMembers()->where('startup_id', $startup->id)->exists();
        $hasRole = auth()->user()->startupMembers()
            ->where('startup_id', $startup->id)
            ->whereIn('role', ['OWNER', 'EDITOR'])
            ->exists();

        if (!$isMember || !$hasRole) {
            return redirect()->route('home')->with('error', 'You do not have the necessary permissions to manage this startup.');
        }

        // Create the new member in the startup_members table
        $role = $request->input('role');  // Get the selected role (owner, editor, or viewer)

        if (!in_array($role, ['OWNER', 'EDITOR', 'VIEWER'])) {
            return redirect()->back()->with('error', 'Invalid role selected.');
        }

        // Add the user as a member of the startup with the selected role
        StartupMember::create([
            'user_id' => $joinRequest->user_id,
            'startup_id' => $startup->id,
            'role' => $role
        ]);

        // Delete the join request after accepting
        $joinRequest->delete();

        // Redirect back with success message
        return redirect()->route('startup.manage', ['id' => $startup->id])->with('success', 'Join request accepted and member added.');
    }

    /**
     * Deny a join request.
     *
     * @param int $startupId
     * @param int $requestId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function denyRequest($startupId, $requestId)
    {
        // Retrieve the startup and join request
        $startup = Startup::findOrFail($startupId);
        $joinRequest = StartupJoinRequest::findOrFail($requestId);

        // Check if the user is authorized to manage this startup
        $isMember = auth()->user()->startupMembers()->where('startup_id', $startup->id)->exists();
        $hasRole = auth()->user()->startupMembers()
            ->where('startup_id', $startup->id)
            ->whereIn('role', ['OWNER', 'EDITOR'])
            ->exists();

        if (!$isMember || !$hasRole) {
            return redirect()->route('home')->with('error', 'You do not have the necessary permissions to manage this startup.');
        }

        // Deny the join request by deleting it
        $joinRequest->delete();

        // Redirect back with success message
        return redirect()->route('startup.manage', ['id' => $startup->id])->with('success', 'Join request denied.');
    }
}
