<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsAuthorized
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
		if (isset(Auth::user()->email)) {
            return $next($request);
        }
        return redirect('/login'); // If user is not an admin.
    }
}
