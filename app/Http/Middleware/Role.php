<?php

namespace App\Http\Middleware;

use Closure;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ... $roles)
    {
        $user = \Auth::user();
        
        foreach ($roles as $role) {
            if ($user->rol->codigo == $role) {
                return $next($request);
            }
        }
        return abort(403);
    }
}
