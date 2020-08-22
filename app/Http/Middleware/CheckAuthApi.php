<?php

namespace App\Http\Middleware;

use Closure;

class CheckAuthApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(is_null(auth('api')->user()))
            return response()->json(['message' => 'Unauthenticated.'], 401);
        else
            return $next($request);
    }
}
