<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureLoggedOut
{
    /**
     * Handle an incoming request.
     *
     * This middleware ensures that users who are already logged in
     * cannot access routes intended for guests (such as login or registration).
     * If the user is logged in, they are redirected to their dashboard.
     *
     * @param  \Illuminate\Http\Request  $request The incoming request.
     * @param  \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response  $next The next middleware to call.
     * @return \Symfony\Component\HttpFoundation\Response The response after the request is processed.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // If the user is logged in, redirect them to their dashboard
        if (auth()->check()) {
            return redirect()->route('user.dashboard');
        }

        // Proceed with the next middleware if the user is not logged in
        return $next($request);
    }
}
