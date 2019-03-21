<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsEditor
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
	if (isset(Auth::user()->email) && Auth::user()->hasAnyRole(['editor','admin'] )) {
            return $next($request);
        }
        return redirect('/login'); // If user is not an editor or admin.
    }
}
