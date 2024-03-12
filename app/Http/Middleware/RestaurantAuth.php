<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestaurantAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next,String $role)
    {
        if (!$request->user()) 
        {
            return redirect('login');
        }
        if (!$request->user()->HasOrGreaterRole($role))
        {
            abort(403, 'Access denied');
        }
        return $next($request);
    }
}
