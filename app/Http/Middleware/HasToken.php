<?php

namespace App\Http\Middleware;

use Closure;

class HasToken
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
        if ($request->session()->has('oauth_token')) {
            return redirect()->route('home');
        }

        return $next($request);

    }
}
