<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    private $whiteList = [
        'Login',
    ];
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
        $controller = mca()['controller'];

        if (! Auth::guard($guard)->check() && ! in_array($controller, $this->whiteList)) {
            return redirect($guard . '/login');
        }
        return $next($request);
    }
}
