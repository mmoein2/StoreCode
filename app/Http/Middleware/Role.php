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
    public function handle($request, Closure $next,$role)
    {
        if(auth()->user()->role->name_en == $role)
            return $next($request);
        else
        {
            return back()->withErrors(['دسترسی غیر مجاز']);
        }
    }
}
