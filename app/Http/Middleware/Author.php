<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Author
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
        if (Auth::user() &&  Auth::user()->type == 'Author') {
            return $next($request);
        }

        // if not admin
        return redirect('/');
    }
}
