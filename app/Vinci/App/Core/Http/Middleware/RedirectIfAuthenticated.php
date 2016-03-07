<?php

namespace Vinci\App\Core\Http\Middleware;

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
            return redirect($this->getRedirectPath($guard));
        }

        return $next($request);
    }

    protected function getRedirectPath($guard)
    {
        if ($guard == 'cms') {
            return '/cms';
        }

        return '/minha-conta';
    }
}
