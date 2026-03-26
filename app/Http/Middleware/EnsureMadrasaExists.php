<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureMadrasaExists
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Agar user login nahi hai
        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.'
            ], 401);
        }

        // Agar user ke paas madrasa assigned nahi hai
        if (!$user->madrasa_id) {
            return response()->json([
                'message' => 'Madrasa not set up. Please complete setup first.'
            ], 403);
        }

        return $next($request);
    }
}