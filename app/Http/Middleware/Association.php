<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Association
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
        if (auth('api')->user() && auth('api')->user()->role_id != 1)
        {
            $response = ['message' => 'You have not the good role!'];
            return response($response, 403);
        }
        return $next($request);
    }
}
