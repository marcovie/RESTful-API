<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;

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
            abort(Response::HTTP_FORBIDDEN, '403 Forbidden');
        else
            return $next($request);
    }
}
