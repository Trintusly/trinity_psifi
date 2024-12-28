<?php

namespace App\Http\Controllers\Startup;

use App\Http\Controllers\Controller;
use App\Models\Startup;

class ViewStartupController extends Controller
{
    /**
     * Display the details of a specific startup.
     *
     * @param int $id ID of the startup to view.
     * @return \Illuminate\View\View The view displaying startup details.
     */
    public function index($id)
    {
        $startup = Startup::with([
            'creator',
            'members.user'
        ])->findOrFail($id);

        // Initialize the ownership and membership flags
        $isOwner = false;
        $isMember = false;
        $isPrimaryStartup = false;
        $hasPendingRequest = false;

        if (auth()->check()) {
            // Check if the user is a member of this startup
            $isMember = auth()->user()->startupMembers()
                ->where('startup_id', $startup->id)
                ->exists();

            // Check if the user is the creator (owner) of the startup
            if ($isMember) {
                if ($startup->creator_id == auth()->user()->id) {
                    $isOwner = true;
                } else {
                    // Check if the authenticated user has the 'OWNER' role in this startup via the startupMembers relationship
                    $isOwner = auth()->user()->startupMembers()
                        ->where('startup_id', $startup->id)
                        ->where('role', 'OWNER')
                        ->exists();
                }

                // Check if the current startup is the primary startup for the user
                $isPrimaryStartup = auth()->user()->primary_startup == $startup->id;
            }

            // Check if the user has a pending join request for this startup
            $hasPendingRequest = auth()->user()->joinRequests()
                ->where('startup_id', $startup->id)
                ->exists();
        }

        // Pass the startup data, owner status, membership status, primary startup status, and pending request status to the view
        return view('startup.view', [
            'startup' => $startup,
            'isOwner' => $isOwner,  // Indicates if the user is the owner
            'isMember' => $isMember,  // Indicates if the user is a member
            'isPrimaryStartup' => $isPrimaryStartup,  // Indicates if the startup is the primary one for the user
            'hasPendingRequest' => $hasPendingRequest,  // Indicates if the user has a pending join request for this startup
            'members' => $startup->members()
        ]);


    }

    public function setPrimaryStartup($id)
    {
        // Retrieve the authenticated user
        $user = auth()->user();

        // Check if the user is a member of the startup
        $isMember = $user->startupMembers()->where('startup_id', $id)->exists();

        if ($isMember) {
            // Check if the startup is already set as primary for the user
            if ($user->primary_startup == $id) {
                // If the startup is already primary, remove it (set to null)
                $user->primary_startup = 0;
                $user->save();

                // Redirect back with a success message
                return redirect()->back()->with('success', 'Primary startup removed successfully.');
            } else {
                // If the startup is not primary, set it as primary
                $user->primary_startup = $id;
                $user->save();

                // Redirect back with a success message
                return redirect()->back()->with('success', 'Primary startup updated successfully.');
            }
        }

        // If the user is not a member, return an error message
        return redirect()->back()->with('error', 'You are not a member of this startup.');
    }

    public function sendJoinRequest($id)
    {
        // Retrieve the authenticated user
        $user = auth()->user();

        // Check if the user is already a member of the startup
        $isMember = $user->startupMembers()->where('startup_id', $id)->exists();

        // Check if there's already a pending join request for this startup
        $existingRequest = $user->joinRequests()->where('startup_id', $id)->first();

        // If the user is a member or a request exists, toggle the request (delete if exists)
        if ($isMember || $existingRequest) {
            if ($existingRequest) {
                // If a request exists, delete it (toggle off)
                $existingRequest->delete();
                return redirect()->back()->with('success', 'Your join request has been canceled.');
            }
        } else {
            // If the user is not a member and no request exists, create a new join request
            $user->joinRequests()->create([
                'startup_id' => $id,
            ]);
            return redirect()->back()->with('success', 'Your join request has been sent.');
        }
    }



}
