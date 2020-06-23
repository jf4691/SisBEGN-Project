<?php

namespace App\Http\Middleware;

use Closure;

class UserNew
{
    /**
     * Handle an incoming request.
     * Middleware para redirigir al usuario nuevo
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::user()->ifnuevo) {
            return redirect('change-pass');
        } else {
            return $next($request);
        }
    }
}
