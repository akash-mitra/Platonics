<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Editor
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
        //return $next($request);
        // if admin
        if (Auth::user() &&  Auth::user()->type == 'Editor') {
            return $next($request);
        }

        // if not admin
        return redirect('/');
    }
}
