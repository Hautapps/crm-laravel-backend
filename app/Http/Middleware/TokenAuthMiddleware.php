<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokenAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $plainToken = $request->bearerToken();

        if (!$plainToken) {
            return response()->json(['message' => 'Missing token'], 401);
        }
    
        $hashedToken = hash('sha256', $plainToken);
    
        $token = \App\Models\ApiToken::where('token', $hashedToken)->first();
    
        if (! $token || ($token->expires_at && $token->expires_at->isPast())) {
            return response()->json(['message' => 'Invalid or expired token'], 401);
        }
    
        Auth::login($token->user);
    
        return $next($request);
    }
}
