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
        $getRoleId = $request->user()->role_id;
        return $next($request);
        console.log($getRoleId);
    }
}
