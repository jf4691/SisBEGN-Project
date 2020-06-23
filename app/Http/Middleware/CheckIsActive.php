<?php

namespace App\Http\Middleware;

use Closure;

class CheckIsActive
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
        if (\Auth::check()) {
            if (!\Auth::user()->estado) {
                \Auth::logout();
                return redirect('/in-active');
            }
        }
        return $next($request);
    }
}
