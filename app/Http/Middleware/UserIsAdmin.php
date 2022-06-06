<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if ($user->roles()->first()->id != 1) {
            if ($request->expectsJson())
                return response()->json([
                    'status_code' => 401,
                    'status_message' => "Unauthorized.",
                    'errors' => [
                        'user' => ["the user $user->name isn't admin."]
                    ]
                ], 401);
            else
                return response('<h1>Unauthorized.</h1>', 401);
        }

        return $next($request);
    }
}
