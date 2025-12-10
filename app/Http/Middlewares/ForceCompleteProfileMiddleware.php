<?php
/*
 * Copyright (c) 2025
 *
 *  @author Juan Manuel Cortéz <juanm.cortez@gmail.com>
 *  @copyright 2025 Nobidium LLC.
 *  @license MIT License
 */

namespace App\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceCompleteProfileMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // If user is authenticated and profile is not completed
        if ($user && !$user->profile_completed) {
            // Allow access to profile completion route and logout
            if (!$request->routeIs('profile.complete', 'profile.store', 'logout')) {
                return redirect()->route('profile.complete');
            }
        }

        return $next($request);
    }
}
