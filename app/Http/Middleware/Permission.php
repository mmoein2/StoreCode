<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$permission_name)
    {
        if(auth()->user()->email=='admin')
        {
            return $next($request);
        }

        if(Gate::allows($permission_name,$permission_name))
        {
            return $next($request);
        }
        return abort(403);

    }
}
