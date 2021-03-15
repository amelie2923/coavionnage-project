<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

class React
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
        //verify if user token is passed in header
        $token = $request->bearerToken();
        if(!$token){
            return response()->json(['message' => 'Missing token'], 403);
        }
        // $request->user()->id
        // auth('api')->user()
        // $user = $request->auth('api')->user()->first();

        if(!$user){
            return response()->json(['message' => 'Invalid credentials'], 403);
        }
        // Auth::login($user);

        return $next($request);
    }
}
