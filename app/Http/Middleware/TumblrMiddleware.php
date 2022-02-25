<?php

namespace App\Http\Middleware;

use Closure;

class TumblrMiddleware
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
        if (!$request->session()->exists('oauth_token')) {
            // oauth_token value cannot be found in session
            laraflash('Not Autorized !', 'Error')->danger();
            return redirect('/');
        }

        return $next($request);

    }
}
