<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * This middleware checks if the user is authenticated.
     * If the user is not logged in, they are redirected to the login page.
     *
     * @param  \Illuminate\Http\Request  $request The incoming request.
     * @param  \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response  $next The next middleware to call.
     * @return \Symfony\Component\HttpFoundation\Response The response after the request is processed.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            // Redirect to login if the user is not logged in
            return redirect()->route("login");
        }

        // Proceed with the next middleware if the user is logged in
        return $next($request);
    }
}
