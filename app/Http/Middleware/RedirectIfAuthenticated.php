<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;//quitar esta linea si es necesario
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            return redirect(RouteServiceProvider::HOME);
            //return redirect('/home'); //poner esta linea en vez de la de arriba
        }

        return $next($request);
    }
}
