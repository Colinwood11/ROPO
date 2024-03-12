<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostLog
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
        if ($request->isMethod('post')) {
            $data = $request->all();
            unset($data['password']);
            unset($data['_token']);
            Log::channel('PostContent')->info($request->ip()." incoming post:".$request->path());
            Log::channel('PostContent')->info($data);
        }
        return $next($request);
    }
}
